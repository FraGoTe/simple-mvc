<?php
class blogController extends Controller {    

    protected function init(){    
        $this->db = new MySqlDataAdapter($this->cfg['db']['hostname'], $this->cfg['db']['username'], 
        $this->cfg['db']['password'], $this->cfg['db']['database']);
    }
	
	public function index(){
		$data = $this->_model->read();
		if(MyHelpers::isAjax()){
			header('Content-type: application/json');
			echo $data;
		}else{
			$this->view->set('items',$data);
		return $this->view();
		}
	}
	
	public function detail($id){
		if(empty($id)){
			return $this->unknownAction();
		}
		
		$data = $this->_model->read($id);
		$this->view->set('item',$data[0]);
		return $this->view();		
	}
	
	public function edit($id, $author=null, $title=null, $content=null){
		if(empty($id)){
			return $this->unknownAction();
		}
		
		if($_SERVER["REQUEST_METHOD"]=='POST'){		
			$row = $this->_model->update($id,$author,$title,$content);
			if($row!== false){
				$this->view->set('item',$row);
			}
		}
		else{
			$data = $this->_model->read($id);
			$this->view->set('item',$data[0]);			
		}
		return $this->view();		
	}

	public function create($author=null, $title=null, $content=null){
		if($_SERVER["REQUEST_METHOD"]=='POST'){		
			$id = $this->_model->create($author,$title,$content);
			if($id !== false){
				header('Location: /mvc/blog/detail/'.$id);
				exit;
			}
		}
		return $this->view();
	}
	
	public function delete($id){
		if($_SERVER["REQUEST_METHOD"]=='POST'){
			$result = $this->_model->delete($id);
			if($result !== false){
				header('Location: /mvc/blog');
				exit;
			}
		}
	}
}