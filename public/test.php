<html>
	<head>
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
			    store: Ext.data.StoreManager.lookup('itemsStore'),
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
			    /**
			     * Title renderer
			     * @private
			     */
			    formatTitle: function(value, p, record){
			        return Ext.String.format('<div class="topic"><b>{0}</b><span class="author">{1}</span></div>', value, record.get('author') || "Unknown");
			    },
			
			    /**
			     * Date renderer
			     * @private
			     */
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
			    height:500,
			    renderTo: 'bloglist'
			});	
		});		
		</script>
</head>
<body>
<div class="block bgWhite"><div class="content"><div id="bloglist"></div></div></div>
</body>
</html>