<?php
class blogModel extends Model{
	protected function init(){
		
	}	
	
	public function create($author,$title,$content){
		$id = false;
		$result = $this->db->query("INSERT INTO `blog`(`author`,`title`,`content`,`last_update`) VALUES('$author','{$title}','{$content}',NOW())");
		if($result !== false){
			$id = $this->db->insertId();
		}			
		return $id;
	}
	
	public function read($id=false){		
		$data = array();
		$q = "";
		if(!empty($id)){
			$q = "WHERE `id`={$id}";
		}
		$start = isset($_GET['start']) ? $_GET['start'] : 0;
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
		$query = "SELECT * FROM `blog` {$q} ORDER BY `last_update` DESC LIMIT {$start},{$limit}";

		$result = $this->db->query($query);
		
		$nbrows = $this->db->fetchRow($this->db->query("SELECT COUNT(*) FROM `blog`"));
		$nbrows = $nbrows[0];
		while($row=$this->db->fetchAssoc($result)){
			$data[]=$row;
		}

		if(MyHelpers::isAjax()){
			// prepare the metadata
			$ret['metaData'] =   $this->makeMetaData($result);
			$ret['total']    =   $nbrows;
			$ret['data']     =   $this->Char2Utf8($data);
			$ret['success']  =   true;
			$ret['message']  =   true;
			return json_encode($ret);
		}
		return $data;		
	}
	
	public function update($id,$author, $title,$content){		
		$result = $this->db->query("UPDATE `blog` SET `author`='$author', `title`='{$title}', `content`='{$content}', `last_update`=NOW() WHERE `id`={$id}");		
		$result = $this->db->query("SELECT * FROM `blog` WHERE `id`={$id}");
		$row=$this->db->fetchAssoc($result);
		return $row;			
	}
	
	public function delete($id){
		$result = $this->db->query("DELETE FROM `blog` WHERE `id`={$id}");		
		return $result;		
	}
	
    protected function Char2Utf8($var){
        if (is_array($var)) {
            $out = array();
            foreach ($var as $key => $v) {
                $out[$key] = $this->Char2Utf8($v);
            }
        } else {
            if(gettype($var)=='string'){
                $out = str_replace(chr(194), "", $var);
                $out = utf8_encode($out);
            }
            else
              $out = $var;  
        }       
        return $out;                   
    }
	
    protected function makeMetaData($result, $overrides = false){
        $metaData['idProperty'] = 'id';
        $metaData['totalProperty'] = 'total';
        $metaData['successProperty'] = 'success';
        $metaData['root'] = 'data';        
        $metaData['fields'] = $this->parseMetaDataFields($result, $overrides);        
        
        return $metaData;
    }
	
    protected function parseMetaDataFields($result, $overrides = false){
        // gets the table of the $result
        $table = $this->table;
        // gets the table descriptions for future use
        $columnsInfo = $this->db->getFullColumnsInfo($table);
        // gets the number of fields
        $nbFields = $this->db->numFields($result);
        // starts a empty array
        $fields = array();
        // loop through the fields
        for ($i=0; $i < $nbFields; $i++){
          $name  = $this->db->fieldName($result, $i);
          $fields[$i]['name']  = $name; 
          		
          if(array_key_exists($name, $columnsInfo)){
            $type  = $columnsInfo[$name]['Type'];
                  
            if($type == 'date')
               $fields[$i]['dateFormat'] = 'Y-m-d';
            else if($type == 'datetime')
               $fields[$i]['dateFormat'] = 'c';   
               
            $fields[$i]['type']  = $this->convertType($type);
            
            if($name != 'id'){
                $fields[$i]['allowBlank'] = ($columnsInfo[$name]['Null'] == 'YES') ? true : false;
                // if we have default value in table column
                if(!is_null($columnsInfo[$name]['Default'])){
                	if($columnsInfo[$name]['Default']=='CURRENT_TIMESTAMP'){
                		$fields[$i]['defaultValue'] ='new Date()';
                	}else{
                		$fields[$i]['defaultValue'] = $columnsInfo[$name]['Default'];
                	}                   
                }
            }
          } else {
              $fields[$i]['type'] = 'auto';
          }
          
          if(!empty($overrides) && is_array($overrides)){
            if(array_key_exists($name, $overrides)){
                foreach($overrides[$name] as $key=>$value){
                    $fields[$i][$key]=$value;
                }
            }
          }
        }
        return $fields;
    }

    protected function convertType($type){
        if(strpos($type,'(') !== false){
            $type = substr($type, 0, strpos($type,'('));
        }

        switch($type){
            case 'varchar':
            case 'char':
            case 'text':
            case 'tinytext':
            case 'mediumtext':
            case 'longtext':
                return 'string';
            case 'int':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
                return 'int';
            case 'tinyint':
                return 'boolean';
            case 'real':
            case 'float':
            case 'double':
            case 'decimal':
            case 'numeric':
                return 'float';
            case 'date':
            case 'datetime':
                return 'date';
            default:
                return 'auto';        
        }
    }
}