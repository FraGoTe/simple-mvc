<?php 
if(!MyHelpers::isAjax()){
$this->layout = '~/views/shared/_defaultLayout.php';
if(isset($_GET['extjs']) && $_GET['extjs']==true){
$this->section['head']="
		<!-- Sencha ExtJs 4.2.2 perm link -->
		<script src='http://docs.sencha.com/extjs/4.2.2/extjs-build/examples/shared/include-ext.js'></script>
		<link href='http://docs.sencha.com/extjs/4.2.2/extjs-build/examples/feed-viewer/Feed-Viewer.css' rel='stylesheet' type='text/css'/>
		<script>
        Ext.Loader.setConfig({enabled: true});
        Ext.Loader.setPath('Ext.ux', 'http://docs.sencha.com/extjs/4.2.2/extjs-build/examples/ux');
        Ext.require([
            'Ext.ux.PreviewPlugin'
        ]);
		// Start loading the page        
		Ext.onReady(function(){
			Ext.create('Ext.data.JsonStore', {
			    storeId:'blogStore',
			    autoLoad:true,
				proxy: {
				        type: 'ajax',
				        url: '/mvc/blog', // our data link
				        reader: {
				            type: 'json'
				        }
				    }
			});
			
			Ext.create('Ext.grid.Panel', {
			    title: 'Blog Posts',
			    store: Ext.data.StoreManager.lookup('blogStore'),
	            viewConfig: {
	                itemId: 'view',
	                plugins: [{
	                    pluginId: 'preview',
	                    ptype: 'preview',
	                    bodyField: 'content',
	                    expanded: true
	                }]
	            },
			    columns: [
			        { text: 'ID',  dataIndex: 'id' },
			        { text: 'Title', dataIndex: 'title', flex: 1, renderer: this.formatTitle},
			        { text: 'Author', dataIndex: 'author', hidden: true, width: 200},
			        { text: 'Last Update', dataIndex: 'last_update', renderer: this.formatDate, width: 200}
			    ],
			    dockedItems: [{
			        xtype: 'pagingtoolbar',
			        store: Ext.data.StoreManager.lookup('blogStore'),   // same store GridPanel is using
			        dock: 'bottom',
			        displayInfo: true
			    }],
			    formatTitle: function(value, p, record){
			        return Ext.String.format('<div class=\"topic\"><b>{0}</b><span class=\"author\">{1}</span></div>', value, record.get('author') || \"Unknown\");
			    },
			    formatDate: function(date){
			        if (!date) {
			            return '';
			        }
			
			        var now = new Date(), d = Ext.Date.clearTime(now, true), notime = Ext.Date.clearTime(date, true).getTime();
			
			        if (notime === d.getTime()) {
			            return 'Today ' + Ext.Date.format(date, 'g:i a');
			        }
			
			        d = Ext.Date.add(d, 'd', -6);
			        if (d.getTime() <= notime) {
			            return Ext.Date.format(date, 'D g:i a');
			        }
			        return Ext.Date.format(date, 'Y/m/d g:i a');
			    },
			    renderTo: 'bloglist'
			});	
		});		
		</script>
";
}
?>
<?php
if(isset($_GET['extjs']) && $_GET['extjs']==true){
?>
<div class="block bgWhite">
	<div class="content"><div id='bloglist'></div></div>
</div>
<?php } else { ?>
<div class="block bgWhite">
	<div class="content">
		<img src="http://catalizt.com/wp-content/uploads/2013/07/blog-banner.jpg" width="990" alt="" />
	</div>
	<div class="content">
		<?php foreach($items as $item){ ?>
		<a href="./blog/detail/<?php echo $item['id'];?>">
			<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;"><?php echo $item['title']; ?></h1>
		</a>	
		<div>
			<?php echo substr($item['content'], 0, 750).' [...]'; ?>
			<span style="float:right;padding-top:10px;"><?php echo $item['last_update']; ?></span>
		</div>
		<hr style="margin: 10px 0px;">
		<?php }?>
		<span style="float:right;margin-top:20px;"><a href="/mvc/blog/create/"> New Article</a></span>
	</div>
</div><?php }
}?>