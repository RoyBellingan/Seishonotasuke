Ext.onReady(function() {

	ConceptsPanel = function() {
		ConceptsPanel.superclass.constructor.call(this, {
			id: 'id-ConceptsPanel',
			region: 'west',
			title: 'Concepts',
			split: true,
			width: 250,
			minSize: 250,
			maxSize: 400,
			height: 500,
			collapsible: true,
			margins: '0 0 0 5',
			rootVisible: false,
			lines: false,
			enableDrag: true,
			
			root: new Ext.tree.AsyncTreeNode({
				draggable:false,
	            loader : new Ext.tree.TreeLoader({
					 dataUrl : 'js/app/concepts-data.txt'
				})
	        }),

			collapseFirst: false
		});
		
		this.addEvents({addItem:true});

		this.on('contextmenu', this.onContextMenu, this);
	};


	Ext.extend(ConceptsPanel, Ext.tree.TreePanel, {
		onContextMenu : function(node, e) {
			if(!this.menu) {
				this.menu = new Ext.menu.Menu({
					id: 'concepts-ctx',
					items: [{
						id: 'addItem',
						iconCls: 'add-item',
						text: 'Add Item',
						handler: this.addItem,
						scope: this
					}}]
				});
			}
				
			this.menu.showAt(e.getXY());
		},
		
		afterRender : function() {
			ConceptsPanel.superclass.afterRender.call(this);
			this.el.on('contextmenu', function(e) {
				e.preventDefault();
			});
		}
	});
	
	
	ConceptsPanel.render('boxxoso');
	
});