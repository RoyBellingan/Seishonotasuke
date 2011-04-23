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
	
	/*********
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
	


    
    
    
    /*********************************************/
     //Categorie
    
    /**Peccato al momento sia bugghissimo**/
    /*
     * 
     var tree = new Ext.tree.TreePanel({
        store: store,
        rootVisible: false,
        useArrows: true,
        frame: true,
        border: true,
        title: 'Categorizzazione',
       // renderTo: 'tree-div',
        width: 300,
        height: 400
    });
    */
    /**Rimpiazzo */
    var tree = new Ext.Panel({
    		// renderTo: Ext.getBody(),
    		title:'Categorizzazione',
    		deferredRender:false,
    		id:'tree_tab',
    		// id:'visite_tab',
    		layout: 'border',
    		border:false,
    		frame:true,
    		layout:'fit',
    		items: [{   

    		        xtype:'textarea',
    		        id:'categorie_text',
    		        name:'categorie',
    		        fieldLabel:'categorie',
    		        widht:'100%',
    		        height:400,
    		        value:"/*\nUna categoria su ogni riga, già da adesso le puoi annidare cosi\n" +
    		        		"Città / Parigi\n" +
    		        		"Cultura / Musei / Louvre\n" +
    		        		"Per favore le date scrivile cosi Anno - Mese */\n"

    		}]
    		
    	});
    
	/** ********************************************************************* */
	// Monoblocco
		/** ********************************************************************* */
    var tab2 = Ext.create('Ext.form.FormPanel', {
        bodyStyle:'padding:5px',
        width: 1000,
        border:false,
        frame:true,
        url:'login.php',
		style:'margin:auto',
        fieldDefaults: {
            labelAlign: 'top',
            msgTarget: 'side'
        },
        defaults: {
            anchor: '100%'
        },

        items: [{
            layout:'column',
            border:false,

            items:[{
                columnWidth:.5,
                border:false,
                layout: 'anchor',
                defaultType: 'textfield',
                items: [{
                    fieldLabel: 'Titolo',
                    name: 'titolo',
                    anchor:'95%'
                }, {
                    fieldLabel: 'Oratore',
                    name: 'oratore',
                    anchor:'95%'
                }]
            },{
                columnWidth:.5,
                border:false,
                layout: 'anchor',
                defaultType: 'textfield',
                items: [{
                    fieldLabel: 'Data',
                    xtype:'datefield',
                    value: new Date(),
                    name: 'data',
                    anchor:'95%'
                }/*,{
                    fieldLabel: 'Email',
                    name: 'email',
                    vtype:'email',
                    anchor:'95%'
                }*/
                ]
            }]
        },{
            xtype:'tabpanel',
            plain:true,
            border:false,
            frame:false,
            
            activeTab: 0,
            defaults:{bodyStyle:'padding:10px'},
            items:[{
                cls: 'x-plain',
                title: 'Testo',
                layout: 'fit',
                height:640,
                items: {
                    xtype: 'htmleditor',
                    name: 'testo',
                }
            },tree
            ,{
                title:'Altro',

                items: [{
                    fieldLabel: 'Riassunto',
                    name: 'riassunto',
                    xtype: 'textarea',
                    width: 430,
                    height: 130
                },{
                	xtype: 'numberfield',
                    fieldLabel: 'Rating (1-10)',
                    name: 'rating',
                    value: 6,
                    minValue: 1,
                    maxValue: 10,
                    allowDecimals: true,
                    decimalPrecision: 1,
                    step: 0.1

                }/*,{
                   // xtype: 'filefield',
                	xtype: 'numberfield',
                    name: 'Allegati',
                    fieldLabel: 'Allegati'
                }*/
                ]
            }
            ]
        }],

        buttons: [{
            text: 'Salva',
            handler:function(){
        	tab2.getForm().submit({
        		url:'ajax/discorsi/push_discorso.php?neu=1',
        		standardSubmit: true,
        		waitTitle:'Connecting', 
                waitMsg:'Sending data...',
                success: function(f,a){
				//var kek=action.response.responseText
				//var jsonData = Ext.util.JSON.decode(kek);
        			Ext.Msg.alert('Ok',a.result.success);
        			
        		},
        		failure: function(f,a){
        			Ext.Msg.alert('Failed',a.result.error || a.response.responseText);
        				}
            	}); 
        	}
        },{
            text: 'Reset',
            handler:function(){
        	tab2.getForm().reset();
        	}
        }
        ]
    });

    tab2.render('boxxoso');
	   

	});
