/*!
 * Ext JS Library 3.0.0
 * Copyright(c) 2006-2009 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){
// TODO aggiungi in un altra pagina un selettore di persone in base a DATA e
// POSIZIONE, e da quello linka a questo form (suggerito da Renzo poichè succede
// che magari non ricordi altrose non appunto dove lo hai visto e quando)

// TODO aggiungi il tasto per creare nuove entry nelle varie griglie! ->
// http://susi/ext-3/examples/writer/writer.html

// TODO carino ! il sorting custom
// http://susi/ext-3/examples/grid/multiple-sorting.html

// TODO simile a quello che uso per il fetch del DB nel GAS/inserisci cedolini
// per filtrare i risultati
// http://susi/ext-3/examples/grid-filtering/grid-filter-local.html

	
	
	// Lista Categorie (chiamala via php ecc)
    var children = [{
        text:'Istruzione'
       ,children:[{
            text:'Teocratico'
           ,children:[{
               text:'Mantenersi Puri'
              ,leaf:true
          },{
              text:'Adorazione'
                  ,leaf:true
              },{
                  text:'Intendimento'
                      ,leaf:true
                  }]
       },{
            text:'AnarcoCattoCosi'
           ,leaf:true
       }]
   },{
        text:'Avvertimento'
       ,children:[{
            text:'Tempo della Fine'
           ,leaf:true
       },{
            text:'Occhio Semplice'
           ,leaf:true
       }]
    
   }];

// L'albero in se
    var tree = new Ext.tree.TreePanel({
    	frame:false,
    	border:false,
    	id:'albero_cat',
        loader:new Ext.tree.TreeLoader()
       ,anchor:'95%'
       ,height:250
       ,renderTo:Ext.getBody()
       ,root:new Ext.tree.AsyncTreeNode({
            expanded:true
           ,leaf:false
           ,text:'Discorsi'
           ,children:children
       })
   });
	
	
/********************************************************************/
    //Lista discorsi
/********************************************************************/
	// Lista "grezza
	var discorsi_store= new Ext.data.JsonStore({
		autoload:true,
		url: 'ajax/discorsi/pull_discorso.php',
		fields:[
		    	{name: 'id', type: 'int'},
		    	{name: 'data', type: 'date', dateFormat: 'd/m/Y'},
		    	{name: 'titolo'},
		    	{name: 'oratore',},
		    	{name: 'testo2'},
		    	{name: 'testo'},
		    	{name: 'riassunto'}
		        ],
		        baseParams: { command: 'not implemented yeth', id: '', title: '', oratore: '', riassunto:'', data:'', data2:'', parole:'', categorie:'' }
	});
	

	var grid_discorsi = new Ext.grid.GridPanel({
		
		// id:'mag_griglia',
		// name:'mag_griglia',
		frame: true,
		id:"grid_discorsi",
		columns: [
		{header: "id", width: 20, sortable: true, dataIndex: 'id'},
		{id:'data',header: "Data (g/m/a)", width: 50, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y'), dataIndex: 'data'},
		{header: "Titolo", width: 220, sortable: true, dataIndex: 'titolo'},
		{header: "Oratore", width: 50, sortable: true, dataIndex: 'oratore'}
		],
		store: discorsi_store,
		width: '100%',
		height: 450,
		listeners:{
            render: function(grid){
                grid.store.load();
            }
         },
		viewConfig: {
			forceFit: true
		},

		split: true,
		region: 'west',
		// sm: new Ext.grid.RowSelectionModel({singleSelect: true}),
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true,
			listeners: {
				rowselect: function(sm, row, rec) {
					Ext.getCmp("corpo").getForm().loadRecord(rec);
					//Questa riga qua sopra mi è un poco misterioso ma amen... getcmp vuole l'id del form in cui caricare il dato.
				}
			}
		}),
			
		})	
	
	
	
	
	
	/** **************************************************************************** */
	// Cronologico appunti e griglia principale
	/** **************************************************************************** */
		
	var tab_1 = new Ext.Panel({
		// renderTo: Ext.getBody(),
								title:'Discorsi',
								// id:'visite_tab',
								layout: 'form',
								frame:false,
								items: [grid_discorsi,{									
									split: true,
									// frame:true,
									frame:true,
									layout:'fit',	
											items: [{
												fieldLabel: 'Testo',
												name: 'testo',
												xtype:'htmleditor',
												height:270,
												widht:'100%'

											}],
											buttons: [{
									            text: 'Refresh',
									            handler:function(){


												Ext.getCmp('grid_discorsi').getStore().reload({
									                FND_NAME: "7",
									                STATUS: "pepette"
												});
									        	}
									        },{
									            text: 'Aggiorna',
									            handler:function(){
									        	tab2.getForm().submit({
									        		url:'ajax/discorsi/push_discorso.php?up=1',
									        		standardSubmit: true,
									        		waitTitle:'Connecting', 
									                waitMsg:'Sending data...',
									                success: function(f,a){
									        		Ext.getCmp('grid_discorsi').getStore().reload();
													//var kek=action.response.responseText
													//var jsonData = Ext.util.JSON.decode(kek);
									        		Ext.getCmp('corpo').getStore().reload(); 
									        			Ext.Msg.alert('Ok',a.result.success);
									        		},
									        		failure: function(f,a){
									        			Ext.Msg.alert('Failed',a.result.error || a.response.responseText);
									        				}
									            	}); 
									        	}
									        },{
									            text: 'Cancella',
									            handler:function(){
									        	tab2.getForm().submit({
									        		url:'ajax/discorsi/push_discorso.php?del=1',
									        		standardSubmit: true,
									        		waitTitle:'Connecting', 
									                waitMsg:'Sending data...',
									                success: function(f,a){
									        		Ext.getCmp('grid_discorsi').getStore().reload();
													//var kek=action.response.responseText
													//var jsonData = Ext.util.JSON.decode(kek);
									        			Ext.Msg.alert('Ok',a.result.success);
									        			//TODO e cancella la linea...
									        		},
									        		failure: function(f,a){
									        			Ext.Msg.alert('Failed',a.result.error || a.response.responseText);
									        				}
									            	}); 
									        	}
									        }]

									
								}]
	});
	


/** ********************************************************************* */
// Editor di testo
/** ********************************************************************* */
	var tab_editor = new Ext.Panel({
		// renderTo: Ext.getBody(),
		title:'Testo',
		deferredRender:false,
		id:'editor_tab',
		// id:'visite_tab',
		layout: 'border',
		border:false,
		frame:true,
		layout:'fit',
		items: [{   

		        xtype:'htmleditor',
		        id:'editor',
		        name:'testo2',
		        fieldLabel:'text_extended',
		        widht:'100%'

		}],
		buttons: [{
            text: 'Aggiorna',
            handler:function(){
        	tab2.getForm().submit({
        		url:'ajax/discorsi/push_discorso.php?up=1',
        		standardSubmit: true,
        		waitTitle:'Connecting', 
                waitMsg:'Sending data...',
                success: function(f,a){
        		Ext.getCmp('grid_discorsi').getStore().reload();
				//var kek=action.response.responseText
				//var jsonData = Ext.util.JSON.decode(kek);
        		Ext.getCmp('corpo').getStore().reload(); 
        			Ext.Msg.alert('Ok',a.result.success);
        		},
        		failure: function(f,a){
        			Ext.Msg.alert('Failed',a.result.error || a.response.responseText);
        				}
            	}); 
        	}
        }]
		
	});
	
	
/** ********************************************************************* */
// Altro
/** ********************************************************************* */
	var tab_varie = new Ext.Panel({
		// renderTo: Ext.getBody(),
		title:'Varie',
		// id:'visite_tab',
		layout: 'form',
		frame:false,
		items: [{
            xtype:'textfield',
            fieldLabel: 'Varie',
            name: 'id',
            anchor:'95%'
        },{
            xtype:'textfield',
            fieldLabel: 'Ed',
            name: 'nome',
            anchor:'95%'
        },{
            xtype:'textarea',
            fieldLabel: 'Eventuali',
            height:'65px',
            name: 'cognome',
            anchor:'95%'
        }]
	});	

	
	/** ********************************************************************* */
	// Monoblocco
	/** ********************************************************************* */


    var tab2 = new Ext.FormPanel({
		id: 'corpo',
        labelAlign: 'top',
        title:false,
        bodyStyle:'padding:5px;',
	    frame:true,
		style:'margin:auto',
	// layout:'ux.center',
		
        width: '95%',
        items: [{
            layout:'column',
            border:false,
            items:[{
                columnWidth:.4,
                layout: 'form',
                border:false,
				// store:interessati_store,
				// mag_store.load();
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Titolo',
                    name: 'titolo',
                    id: 'titolo',
                    anchor:'95%'
                },{
                    xtype:'textfield',
                    fieldLabel: 'Oratore',
                    name: 'oratore',
                    id: 'oratore',
                    anchor:'95%'
                },{
                    xtype:'textarea',
                    fieldLabel: 'Riassunto',
                    height:'65px',
                    name: 'riassunto',
                    id: 'riassunto',
                    anchor:'95%'
                },{
                    layout:'column',
                    border:false,
                    items: [{
                        columnWidth:.35,
                        layout: 'form',
                        border:false,
                        items: [{

                        fieldLabel: 'Inizio',
                        xtype:'datefield',
                        name: 'data',
                        format:'d/m/Y',
                        id: 'data',
                        anchor:'95%'
                        }]
                    },{
                        columnWidth:.35,
                        layout: 'form',
                        border:false,
                        items: [{

                        fieldLabel: 'Fine',
                        xtype:'datefield',
                        name: 'data2',
                        format:'d/m/Y',
                        id: 'data2',
                        anchor:'95%'
                        }]
                    },{
                        columnWidth:.2,
                        layout: 'form',
                        border:false,
                        items: [{
                        fieldLabel: 'id',
                        xtype:'textfield',
                        name: 'id',
                        id: 'id',
                        anchor:'95%'
                        }]
                    }]
                }]
                
            },{
            	columnWidth:.25,
                layout: 'form',
                border:false,
                items: [{
                    fieldLabel: 'parole',
                    padding:10,
                    xtype:'textarea',
                    name: 'Ricerca',
                    id: 'parole',
                    anchor:'95%',
                    height:230
                }]
            },{
                columnWidth:.25,
                layout: 'form',
                border:false,
                items: [albero_cat]
            }],
            buttons: [{
	            text: 'Cerca',
	            handler:function(){

//Cambio i parametri di base della richiesta, e poi "refresho lo store"            	
//baseParams: { command: 'not implemented yeth', id: '', title: '', oratore: '', riassunto:'', data1:'', data2:'', parole:'', categorie:'' }
				
            	discorsi_store.setBaseParam('command', 'qq');
				discorsi_store.setBaseParam('id', document.getElementById("id").value);
				discorsi_store.setBaseParam('title', document.getElementById("titolo").value);
				discorsi_store.setBaseParam('oratore', document.getElementById("oratore").value);
				discorsi_store.setBaseParam('riassunto', document.getElementById("riassunto").value);
				discorsi_store.setBaseParam('data', document.getElementById("data").value);
				discorsi_store.setBaseParam('data2', document.getElementById("data2").value);
				discorsi_store.setBaseParam('parole', document.getElementById("parole").value);
				//discorsi_store.setBaseParam('categorie', document.getElementById("albero_cat").value);
            	
				Ext.getCmp('grid_discorsi').getStore().reload();
            	

	        	}
	        },{
    			text: 'Reset',
    			handler:function(){
	        	tab2.getForm().reset();
	        	}

    		}]
            
        },{
            xtype:'tabpanel',
            plain:true,
// frame: true,
// border:true,
            activeTab: 0,
            height:800,
            defaults:{bodyStyle:'padding:2px'},
            items:[
            tab_1,
            tab_editor,
			tab_varie
			]
// gmaps-tab,
// annotazioni_tab,
// materiale1_tab,
// materiale2_tab,
// eventi_tab,
// timeline_tab
// info

			/*
			 * Altri campi potrebbero essere un riassunto degli altri
			 * 
			 */

        }]
    });
// grid_1.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
// var detailPanel = Ext.getCmp('detailPanel');
// bookTpl.overwrite(detailPanel.body, r.data);
// });
     tab2.render("boxxoso");



    
    
    
    
    
    
});



