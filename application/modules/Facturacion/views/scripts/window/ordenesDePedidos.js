﻿Ext.ns( 'Apps' );

Apps.<?=$this->name?> = Ext.extend(RadDesktop.Module, {
	title: '<?=$this->title?>',
	appChannel: '/desktop/modules<?=$this->url()?>',
	requires: [
      '/direct/Facturacion/OrdenesDePedidos?javascript'
    ],
	
	eventfind: function (ev) {
		this.createWindow();
		var p = this.grid.buildFilter(0, 'Id', ev.value);
		this.grid.store.load({params:p});
	},
	
	eventsearch: function (ev) {
		this.createWindow();
		var p = this.grid.buildFilter(0, ev.field, ev.value);
		this.grid.store.load({params:p});
	},
	
    eventlaunch: function(ev) {
		this.createWindow();
    },

    createWindow: function() {
        var win = app.desktop.getWindow(this.id+'-win');
        if ( !win ) {
			this.createGrid();
			this.createEditorWindow();
            win = this.create();
		}
        win.show();
    },
	
	/**
	 * Crea la ventana del Abm
	 */
	createEditorWindow: function () {
		// Forulario principal
		this.form   = Ext.ComponentMgr.create(<?=$this->form?>);
		// despues del submit exitoso se pasa al paso 1 del wizard
		this.form.on(
			'actioncomplete', 
			function() {
				this.wizard.setActiveItem(1);
			},
			this
		);
		
		this.createWizard();
		this.grid.abmWindow = app.desktop.createWindow({
				autoHideOnSubmit: false,
				width  : 900,
				height : 450,
				border : false,
				layout : 'fit',
				ishidden : true,
				title  : 'Ordenes de Pedidos', 
				plain  : true,
				items  : this.wizard,
				form   : this.form,
				grid   : this.grid,
				getForm: function() {
					return this.form;
				}
			},		
			Rad.ABMWindow
		);
		// si la ventana se esconde volvemos al primer paso
		this.grid.abmWindow.on('hide', function(){
				this.wizard.setActiveItem(0);
				id = this.form.getForm().findField('Id').getValue();
				if (id != 0) {
				// Actualizo la grilla
				Rad.callRemoteJsonAction ({
					url: '/datagateway/get/m/Facturacion/model/OrdenesDePedidos/',
					params: {id: id},
					scope: this,
					success: function(response) {
						this.form.updateGridStoreRecord(response.data);
					}
				});
				}
			}, this
		);
	},
	
	/**
	 * Creo el wizard del abm
	 */
	createWizard: function() {
		this.createSecondaryGrids();
		
		// Creamos el Obj wizard
		this.wizard = new Rad.Wizard({
			border: false,
			defaults: {border:false},
			items: [
				this.renderWizardItem('Ingresar los datos de la Orden de Pedido:','',this.form),
				this.renderWizardItem('Completar datos de los artículos:','',this.gridArt),
				this.renderWizardItem('Finalizar Orden de Pedido:','',this.renderPaso3())
			]
		});
		
		// Logica del Wizard
		this.wizard.on(
			'activate', 
			function (i) {
				switch(i) {
					case 1:	// Si activo el paso 1 cargo la grilla Ordenes de Pedido
						detailGrid = {remotefield: 'Comprobante', localfield: 'Id'};
						form = this.form.getForm();
						id   = form.findField('Id').getValue();
						
						this.gridArt.parentForm = this.form;
						this.gridArt.loadAsDetailGrid(detailGrid, id);
						
                    break;
                    case 2:
                        Ext.getCmp('impresionOrdenesDePedidosHtml').setSrc('/Window/birtreporter/report?template=Comp_PedidoDeCliente_Ver&output=html&id='+ this.form.getForm().findField('Id').getValue());
                    break;
				}
			}, 
			this
			
		);
		
		this.wizard.on('next', function (i) {
				switch(i) {
					case 0:	
						this.form.submit();
						return false;
					break;
				}
			}, this
		);
		
		this.wizard.on('finish', function(i) {
			this.grid.abmWindow.closeAbm();
		},this);
	},
	
	/**
	 * Creamos las grillas secundarias y su logica
	 */
	createSecondaryGrids: function () {
		// Remitos
		this.gridArt = Ext.ComponentMgr.create(<?=$this->gridArt?>);
        this.gridArt.abmForm.reloadGridOnClose = true;
	},

	/**
	 * Creamos la grilla principal
	 */
	createGrid: function () {
		this.grid = Ext.ComponentMgr.create(<?=$this->grid?>);
		this.grid.getTopToolbar().addButton([{xtype:'tbseparator'}, this.anular()]);
	},
	

	/**
	 * Crea la ventana del modulo
	 */
    create: function() {
        return app.desktop.createWindow({
            id: this.id+'-win',
            title: this.title,
            width: 1000,
            height:500,
			border: false,
            shim:   false,
            animCollapse: false,
            layout: 'fit',
            items: [
				this.grid
			]
        });
    },
	
	/**
	 * Da formato a los items del wizard
	 */ 
	renderWizardItem: function (titulo, subtitulo, contenido) {
		return {
			layout: 'fit',
			border : false,
			frame : false,
			items:  {
				layout : 'border',
				border : false,
				items : [{
						region : 'north',
						layout: 'fit',
						border: false,
						height : 50,
						items : {
							layout: 'fit',
							border: false,
							html: '<img style=\'float:right;\' src=\'/images/268498431.png\'><Font style=\'COLOR:#336699;FONT-FAMILY:Arial;FONT-SIZE:16pt;text-align:center;PADDING-TOP:50px;\'>'+titulo+'</font><br><Font style=\'COLOR:#336699;FONT-FAMILY:Arial;FONT-SIZE:10pt;text-align:center;padding-left:5px;\'>'+subtitulo+'</font>'
						}
					},{
						region : 'center',
						layout: 'fit',
						border: false,
						items : [{
							layout: 'fit',
							items: contenido
						}]
				}]
			}
		}
	},
	
    renderPaso3: function () {
        return {
            layout: 'fit',
            border: false,
            items:  [{
                xtype: 'iframepanel',
                id: 'impresionOrdenesDePedidosHtml',
                bodyStyle: 'background-color:white;'
            }],
            buttons : [{
                text: 	'Cerrar Orden de Pedido',
                scope: this,
                handler: function() {
                    var Id = this.form.getForm().findField('Id').getValue();
                    Models.Facturacion_Model_OrdenesDePedidosMapper.cerrar(Id, Ext.emtpyFn, this); 
					this.grid.abmWindow.closeAbm();					
                }
            }]
        };
    },

    anular: function ()
    {
        return {
            text: 'Anular',
            iconCls: 'x-btn-text-icon',
            icon: 'images/cancel.png',
			handler: function() {
				selected = this.grid.getSelectionModel().getSelected();
				if (!selected) {
					Ext.Msg.show({
						title: 'Atencion',
						msg: 'Seleccione un Registro',
						modal: true,
						icon: Ext.Msg.WARNING,
						buttons: Ext.Msg.OK
					});
					return;
				}
				if (selected.get('Cerrado')=='0') {
					Ext.Msg.show({
						title: 'Atencion',
						msg: 'Este registro aun no esta cerrado.',
						modal: true,
						icon: Ext.Msg.WARNING,
						buttons: Ext.Msg.OK
					});
					return;
				}
				
				if (Ext.Msg.confirm('Atencion','¿Está seguro que desea anular el comprobante seleccionado?',function(btn) {
				    if (btn == 'yes') {
				        var id = selected.get('Id');
				        this.form.record = selected;
				        Models.Facturacion_Model_OrdenesDePedidosMapper.anular(id, Ext.emtpyFn, this);
			            Models.Facturacion_Model_OrdenesDePedidosMapper.get(id, function(result, e) {
                	        if (e.status) {
                	            this.form.updateGridStoreRecord(result);
                	        }
			            }, this);
				    }
				}, this));

			},
			scope: this			
        }
    }	
	
	
});

new Apps.<?=$this->name?>();
