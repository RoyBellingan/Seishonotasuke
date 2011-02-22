/*!
 * Ext JS Library 3.0.0
 * Copyright(c) 2006-2009 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.onReady(function(){
//TODO aggiungi in un altra pagina un selettore di persone in base a DATA e POSIZIONE, e da quello linka a questo form (suggerito da Renzo poichè succede che magari non ricordi altrose non appunto dove lo hai visto e quando)

//TODO aggiungi il tasto per creare nuove entry nelle varie griglie!  -> http://susi/ext-3/examples/writer/writer.html

//TODO carino ! il sorting custom http://susi/ext-3/examples/grid/multiple-sorting.html

//TODO simile a quello che uso per il fetch del DB nel GAS/inserisci cedolini per filtrare i risultati http://susi/ext-3/examples/grid-filtering/grid-filter-local.html

	// Lista interessati!
	var interessati_proxy= new Ext.data.HttpProxy({
		url: 'ajax/visite/interessati.php'
	});
	//setActiveStyleSheet('Accessibility');
	

	var interessati_reader = new Ext.data.JsonReader({
		totalProperty: 'total',
		successProperty: 'success',
		idProperty: 'id',
		root: 'data'
	}, [
	{name: 'id', type: 'int'},
	{name: 'nome', allowBlank: false},
	{name: 'cognome', allowBlank: false},
	{name: 'note', allowBlank: false}
	// {name: 'data_in', type: 'data_in', dateFormat:'m/d/Y'}
	]);

	var interessati_writer = new Ext.data.JsonWriter();

	// Typical Store collecting the Proxy, Reader and Writer together.
	var interessati_store = new Ext.data.GroupingStore({
		id: 'interessati',
		restful: true,     // <-- This Store is RESTful
		proxy: interessati_proxy,
		reader: interessati_reader,
		writer: interessati_writer,    // <-- plug a DataWriter into the store
										// just as you
		listeners: {
			write : function(store, action, result, response, rs) {
				App.setAlert(response.success, response.message);
			}
		},
		sortInfo:{field: 'nome', direction: "ASC"},
		groupField:'cognome'
		
	});

	/** ************************ */
	
	var interessati_data_proxy= new Ext.data.HttpProxy({
		url: 'ajax/visite/interessati_data.php'
	});
	
// Array data for the grids
Ext.grid.dummyData = [
    ['3m Co',71.72,0.02,0.03,'12/12 12:00am', 'Manufacturing'],
    ['Alcoa Inc',29.01,0.42,1.47,'4/1 12:00am', 'Manufacturing'],
    ['Altria Group Inc',83.81,0.28,0.34,'4/3 12:00am', 'Manufacturing'],
    ['American Express Company',52.55,0.01,0.02,'4/8 12:00am', 'Finance'],
    ['American International Group, Inc.',64.13,0.31,0.49,'4/1 12:00am', 'Services'],
    ['AT&T Inc.',31.61,-0.48,-1.54,'4/8 12:00am', 'Services'],
    ['Boeing Co.',75.43,0.53,0.71,'4/8 12:00am', 'Manufacturing'],
    ['Caterpillar Inc.',67.27,0.92,1.39,'4/1 12:00am', 'Services'],
    ['Citigroup, Inc.',49.37,0.02,0.04,'4/4 12:00am', 'Finance'],
    ['E.I. du Pont de Nemours and Company',40.48,0.51,1.28,'4/1 12:00am', 'Manufacturing'],
    ['Exxon Mobil Corp',68.1,-0.43,-0.64,'4/3 12:00am', 'Manufacturing'],
    ['General Electric Company',34.14,-0.08,-0.23,'4/3 12:00am', 'Manufacturing'],
    ['General Motors Corporation',30.27,1.09,3.74,'4/3 12:00am', 'Automotive'],
    ['Hewlett-Packard Co.',36.53,-0.03,-0.08,'4/3 12:00am', 'Computer'],
    ['Honeywell Intl Inc',38.77,0.05,0.13,'4/3 12:00am', 'Manufacturing'],
    ['Intel Corporation',19.88,0.31,1.58,'4/2 12:00am', 'Computer'],
    ['International Business Machines',81.41,0.44,0.54,'4/1 12:00am', 'Computer'],
    ['Johnson & Johnson',64.72,0.06,0.09,'4/2 12:00am', 'Medical'],
    ['JP Morgan & Chase & Co',45.73,0.07,0.15,'4/2 12:00am', 'Finance'],
    ['McDonald\'s Corporation',36.76,0.86,2.40,'4/2 12:00am', 'Food'],
    ['Merck & Co., Inc.',40.96,0.41,1.01,'4/2 12:00am', 'Medical'],
    ['Microsoft Corporation',25.84,0.14,0.54,'4/2 12:00am', 'Computer'],
    ['Pfizer Inc',27.96,0.4,1.45,'4/8 12:00am', 'Services', 'Medical'],
    ['The Coca-Cola Company',45.07,0.26,0.58,'4/1 12:00am', 'Food'],
    ['The Home Depot, Inc.',34.64,0.35,1.02,'4/8 12:00am', 'Retail'],
    ['The Procter & Gamble Company',61.91,0.01,0.02,'4/1 12:00am', 'Manufacturing'],
    ['United Technologies Corporation',63.26,0.55,0.88,'4/1 12:00am', 'Computer'],
    ['Verizon Communications',35.57,0.39,1.11,'4/3 12:00am', 'Services'],
    ['Wal-Mart Stores, Inc.',45.45,0.73,1.63,'4/3 12:00am', 'Retail'],
    ['Walt Disney Company (The) (Holding Company)',29.89,0.24,0.81,'4/1 12:00am', 'Services']
];

// add in some dummy descriptions
for(var i = 0; i < Ext.grid.dummyData.length; i++){
    Ext.grid.dummyData[i].push('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed metus nibh, sodales a, porta at, vulputate eget, dui. Pellentesque ut nisl. Maecenas tortor turpis, interdum non, sodales non, iaculis ac, lacus. Vestibulum auctor, tortor quis iaculis malesuada, libero lectus bibendum purus, sit amet tincidunt quam turpis vel lacus. In pellentesque nisl non sem. Suspendisse nunc sem, pretium eget, cursus a, fringilla vel, urna.<br><br>Aliquam commodo ullamcorper erat. Nullam vel justo in neque porttitor laoreet. Aenean lacus dui, consequat eu, adipiscing eget, nonummy non, nisi. Morbi nunc est, dignissim non, ornare sed, luctus eu, massa. Vivamus eget quam. Vivamus tincidunt diam nec urna. Curabitur velit.');
}

    var xg = Ext.grid;

    // shared reader
    var reader = new Ext.data.ArrayReader({}, [
       {name: 'company'},
       {name: 'price', type: 'float'},
       {name: 'change', type: 'float'},
       {name: 'pctChange', type: 'float'},
       {name: 'lastChange', type: 'date', dateFormat: 'n/j h:ia'},
       {name: 'industry'},
       {name: 'desc'}
    ]);
    

    
    Ext.QuickTips.init();

    // turn on validation errors beside the field globally
    Ext.form.Field.prototype.msgTarget = 'side';

    var bd = Ext.getBody();

    
    
    var grid =  new xg.GridPanel({
        store: new Ext.data.GroupingStore({
            reader: reader,
            data: xg.dummyData,
			sortInfo:{field: 'price', direction: "ASC"},
            groupField:'industry'
        }),

        columns: [
            {id:'company',header: "Company", width: 60, sortable: true, dataIndex: 'company'},
            {header: "Price", width: 20, sortable: true, renderer: Ext.util.Format.usMoney, dataIndex: 'price'},
            {header: "Change", width: 20, sortable: true, dataIndex: 'change', renderer: Ext.util.Format.usMoney},
            {header: "Industry", width: 20, sortable: true, dataIndex: 'industry'},
            {header: "Last Updated", width: 20, sortable: true, renderer: Ext.util.Format.dateRenderer('m/d/Y'), dataIndex: 'lastChange'}
        ],

        view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),

        frame:true,
        width: 700,
        height: 450,
        collapsible: true,
        animCollapse: false,
        title: 'Grouping Example',
        iconCls: 'icon-grid',
    });
    /*
	 * ================ Simple form =======================
	 */
	var grid_1 = new Ext.grid.GridPanel({
		
		//id:'mag_griglia',
		//name:'mag_griglia',
		frame: true,

		columns: [
		{id:'data',header: "Data (g/m/a)", width: 110, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y'), dataIndex: 'lastChange'},
		{header: "Argomento", width: 120, sortable: true, dataIndex: 'price'},
		{header: "Con", width: 120, sortable: true, dataIndex: 'change'}
		],
		store: new Ext.data.GroupingStore({
			reader: reader,
			data: xg.dummyData,
			//sortInfo:{field: 'lastChange', direction: "ASC"},
			//groupField:'lastChange'
			}),
		width: '75%',
		height: 250,
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
				}
			}
		}),
			
		})	
	
	var grid_2 = new Ext.grid.GridPanel({

		frame: true,
		
		columns: [
		{id:'data',header: "Data (g/m/a)", width: 110, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y'), dataIndex: 'lastChange'},
										{header: "Argomento", width: 120, sortable: true, dataIndex: 'price'},
										{header: "Interesse %", width: 40, sortable: true, dataIndex: 'pctChange'},
										{header: "Con", width: 80, sortable: true, dataIndex: 'change'}
		],
		store: new Ext.data.GroupingStore({
			reader: reader,
			data: xg.dummyData,
			//sortInfo:{field: 'lastChange', direction: "ASC"},
			//groupField:'lastChange'
		}),
		width: '75%',
		height: 250,
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
				}
			}
		}),

		
	});

	var grid_3 = new Ext.grid.GridPanel({
		
		frame: true,
		
		columns: [
		{id:'data',header: "Data (g/m/a)", width: 110, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y'), dataIndex: 'lastChange'},
										{header: "Argomento", width: 120, sortable: true, dataIndex: 'price'},
										{header: "Interesse %", width: 40, sortable: true, dataIndex: 'pctChange'},
										{header: "Con", width: 80, sortable: true, dataIndex: 'change'}
		],
		store: new Ext.data.GroupingStore({
			reader: reader,
			data: xg.dummyData,
			//sortInfo:{field: 'lastChange', direction: "ASC"},
			//groupField:'lastChange'
		}),
		width: '75%',
		height: 250,
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
				}
			}
		}),
		
		
	});
	
	
	/********************************************* VISITE ***********************************/
	var visite_tab = new Ext.Panel({
		//renderTo: Ext.getBody(),
								title:'Visite',
								//id:'visite_tab',
								layout: 'border',
								frame:true,
								items: [grid_1,{									
									split: true,
									region: 'center',
									layout:'form',
									// frame:true,
									frame:true,
									defaults: {width: '97%'},
										defaultType: 'textfield',
											
											items: [{
												fieldLabel: 'Home',
												name: 'company',
												value: '(888) 555-1212'
											},{
												fieldLabel: 'Business',
												name: 'industry'
											},{
												fieldLabel: 'Mobile',
												name: 'mobile'
											},{
												fieldLabel: 'Fax',
												name: 'desc',
												xtype:'textarea',
												height:250
											}],
											buttons: [{
												text: 'Salva'
											},{
												text: 'Aggiorna'
											},{
												text: 'Cancella'
											}]

									
								}]
	});
	
	
	/********************************************* Interessi ***********************************/
	var interessi_tab = new Ext.Panel({
		//renderTo: Ext.getBody(),
		title:'Interessi',
		//id:'visite_tab',
		layout: 'border',
		frame:true,
		items: [grid_2,{
			split: true,
			region: 'center',
			layout:'form',
			// frame:true,
			frame:true,
			defaults: {width: '97%'},
				defaultType: 'textfield',
					
					items: [{
						fieldLabel: 'Home',
						name: 'company',
						value: '(888) 555-1212'
					},{
						fieldLabel: 'Business',
						name: 'industry'
					},{
						fieldLabel: 'Mobile',
						name: 'mobile'
					},{
						fieldLabel: 'Fax',
						name: 'desc',
						xtype:'textarea',
						height:250
					}],
					buttons: [{
						text: 'Salva'
					},{
						text: 'Aggiorna'
					},{
						text: 'Cancella Record'
					}]
					
					
		}]
	});


	var annotazioni_tab = new Ext.Panel({
		//renderTo: Ext.getBody(),
		title:'Interessi',
		//id:'visite_tab',
		layout: 'border',
		frame:true,
		items: [grid_3,{
			split: true,
			region: 'center',
			layout:'form',
			// frame:true,
			frame:true,
			defaults: {width: '97%'},
				defaultType: 'textfield',
					
					items: [{
						fieldLabel: 'Home',
						name: 'company',
						value: '(888) 555-1212'
					},{
						fieldLabel: 'Business',
						name: 'industry'
					},{
						fieldLabel: 'Mobile',
						name: 'mobile'
					},{
						fieldLabel: 'Fax',
						name: 'desc',
						xtype:'textarea',
						height:250
					}],
					buttons: [{
						text: 'Salva'
					},{
						text: 'Aggiorna'
					},{
						text: 'Cancella Record'
					}]
					
					
		}]
	});
	
	
    /*
	 * ================ Form 5 =======================
	 */
    //bd.createChild({tag: 'h2', html: 'Form 5 - ... and forms can contain TabPanel(s)'});

    var tab2 = new Ext.FormPanel({
		id: 'corpo',
        labelAlign: 'top',
        title:false,
        bodyStyle:'padding:5px;',
	    frame:true,
		style:'margin:auto',
	//	layout:'ux.center',
		
        width: '90%',
        items: [{
            layout:'column',
            border:false,
            items:[{
                columnWidth:.4,
                layout: 'form',
                border:false,
				store:interessati_store,
				// mag_store.load();
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'id Persona',
                    name: 'id',
                    anchor:'95%'
                },{
                    xtype:'textfield',
                    fieldLabel: 'Nome',
                    name: 'nome',
                    anchor:'95%'
                },{
                    xtype:'textfield',
                    fieldLabel: 'Cognome',
                    name: 'cognome',
                    anchor:'95%'
                }]
            },{
                columnWidth:.6,
                layout: 'form',
                border:false,
                items: [{
                    xtype:'textarea',
                    fieldLabel: 'Note <span id="prova">brevi</span>',
                    name: 'note_b',
                    anchor:'100%',
		    height:'116px'
                }]
            }]
        },{
            xtype:'tabpanel',
            plain:true,
// frame: true,
// border:true,
            activeTab: 0,
            height:525,
            defaults:{bodyStyle:'padding:10px'},
            items:[
            visite_tab,
			interessi_tab,
			{
            	/******************************************** Biografia ***********************************/
                //cls:'x-plain',
                title:'Biografia',
                layout:'fit',
                items: {
                    xtype:'htmleditor',
                    id:'bio2',
                    fieldLabel:'Biography'
              }
            },{
            	/******************************************** INfo ***********************************/
            	title:'Info',
                layout:'form',
				// defaults: {width: 230},
				// defaultType: 'textfield',
                items: [{
                    layout:'column',
                    border:false,
                    
                    width: 330,
                    items:[{
                        columnWidth:.8,
                        layout: 'form',
                        border:false,
                        items: [{
                            xtype:'textfield',
                            fieldLabel: 'Indirizzo',
                            name: 'via',
                            anchor:'95%'
                        }]
                    },{
                        columnWidth:.2,
                        layout: 'form',
                        border:true,
                        items: [{
                            xtype:'textfield',
							fieldLabel: 'N&nbsp;°&nbsp;Civico',
                            name: 'note_b',
                            anchor:'84%'
        		    
                        }]
                    }]
                },{
                    layout:'column',
                    border:false,
                    width: 330,
                    items:[{
                        columnWidth:.33,
                        layout: 'form',
                        border:false,
                        items: [{
                            xtype:'textfield',
                            fieldLabel: 'Territorio',
                            name: 'via',
                            anchor:'95%'
                        }]
                    },{
                        columnWidth:.33,
                        layout: 'form',
                        border:false,
                        items: [{
                            xtype:'textfield',
                            fieldLabel: 'GPS LAT',
                            name: 'note_b',
                            anchor:'95%'
        		    
                        }]
                    },{
                        columnWidth:.33,
                        layout: 'form',
                        border:false,
                        items: [{
                            xtype:'textfield',
                            fieldLabel: 'GPS LON',
                            name: 'note_b',
                            anchor:'95%'
        		    
                        }]
                    }]
                },{
					fieldLabel: 'Territorio',
					xtype:'textfield',
					name: 'territorio'
					
				},{
					fieldLabel: 'Lingua',
					xtype:'textfield',
					name: 'lingua'
						  
				}]
              }
//               ,
// 			  gmaps-tab,
// 			  annotazioni_tab,
// 			  materiale1_tab,
// 			  materiale2_tab,
// 			  eventi_tab,
// 			  timeline_tab
// 				
			]
			/*
			 * Altri campi potrebbero essere un riassunto degli altri
			 * 
			 */

        }],

        buttons: [{
            text: 'Save'
        },{
            text: 'Aggiorna'
        },{
            text: 'Save'
        },{
            text: 'Cancel'
        }]
    });
// grid_1.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
// var detailPanel = Ext.getCmp('detailPanel');
// bookTpl.overwrite(detailPanel.body, r.data);
// });
    tab2.render("boxxoso");
});



