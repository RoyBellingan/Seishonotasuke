/*!
 * Ext JS Library 3.0.0
 * Copyright(c) 2006-2009 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function() {
	
	Ext.require([
	             'Ext.tree.*',
	             'Ext.data.*'
	         ]);
	
	/***************************************************************************
	 * Albero
	 */
    var store = new Ext.data.TreeStore({
        proxy: {
            type: 'ajax',
            url: 'ajax/discorsi/check-nodes.json'
        },
        root: {
            expanded: true
        },
        sorters: [{
            property: 'leaf',
            direction: 'ASC'
        }, {
            property: 'text',
            direction: 'ASC'
        }]
    });

    
	   var menu = new Ext.menu.Menu(
	   {
	      items:
	    	  [
	           {
	               text: 'Attivo',
	               checked: true
	           }, '-', {
	               text: 'Nuovo Tag'
	           },{
	               text: 'Cancella Tag'
	           },{
	               text: 'Rinomina'
	           }
	       ]
	   }
    		   );

    
    var tree = new Ext.tree.TreePanel({
        store: store,
        id:'tree',
        rootVisible: false,
        useArrows: true,
        frame: true,
        border: true,
        title: 'Categorizzazione',
       // renderTo: 'tre',
        width: 300,
        height: 400,
        contextMenu: new Ext.menu.Menu({
            listeners: {
                itemclick: function(item) {
                    switch (item.id) {
                        case 'delete-node':
                            var n = item.parentMenu.contextNode;
                            if (n.parentNode) {
                                n.remove();
                            }
                            break;
                    }
                }
            }
        }),


        

    });
    tree.render('boxxoso');
    

 Ext.get('tree').on('contextmenu', function(eventObj, elRef, event) {
     
	 eventObj.stopEvent();

     menu.showAt(Ext.EventObject.getXY());
     

     
     var node = tree.view.getSelectionModel().getChecked();
     
     
//pare funge, ma non sò coime prendere i dati
     
     //alert (node);

 });


});
