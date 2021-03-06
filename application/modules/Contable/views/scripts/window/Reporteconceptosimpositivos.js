Ext.ns( 'Apps' );

Apps.<?=$this->name?> = Ext.extend(RadDesktop.Module, {
    autoStart: true,
    title: '<?=$this->title?>',
    appChannel: '/desktop/modules<?=$this->url()?>',

    eventlaunch: function(ev)
    {
        this.createWindow();
    },

    createWindow: function()
    {
        var win = app.desktop.getWindow(this.id+'-win');
        if ( !win ) {
            win = this.create();
        }
        win.show();
    },
	
    create: function()
    {


        defaultWinCfg = {
            id: this.id+'-win',
            title: this.title,
            iconCls: 'icon-grid',
            border:  false,
            shim: false,
            resizable:false,
            animCollapse: false,
            layout: 'fit',
            width: 500,
            height:350,

            items: [
                this.renderWindowContent()
            ]
        };

        return app.desktop.createWindow(defaultWinCfg);
    },
	
    renderWindowContent: function ()
    {
        return {
            xtype: 'form',
            url : '/Contable/ReporteConceptosImpositivos/verreporte',
            layout: 'form',
            border: false,
            bodyStyle: 'padding:10px',
            defaults: {
                border: false
            },
            items: [       
            {
                xtype: 'checkboxgroup',
                fieldLabel: 'Concepto',
                width: 200,
                items: [
                    { boxLabel: 'Retención', name: 'conceptoretencion', inputValue: 'retencion'},
                    { boxLabel: 'Percepción', name: 'conceptopercepcion', inputValue: 'percepcion' }
                ]
            },
          
                {
                    fieldLabel: 'Tipos de Conceptos',
                    xtype:"xcombo",
                    anchor: '96%',
                    displayField: 'Descripcion',
                    name: 'tipodeconcepto',
                    typeAhead:true,
                    valueField: 'Id',
                    allowBlank: true,
                    msgTarget: 'under',
                    triggerAction: 'all',
                    autoLoad:true,
                    selectOnFocus:true,
                    forceSelection:true,
                    forceReload:true,
                    loadingText:"Cargando...",
                    lazyRender:true,
                    store:new Ext.data.JsonStore({
                       id:0,
                       url:"datagateway\/combolist\/model\/TiposDeConceptos\/m\/Base\/search\/Descripcion\/dir\/asc",
                       storeId:"TiposDeConceptosStore"
                    }),
                pageSize:20,
                editable:true,
                autocomplete:true
                },
                {
                    fieldLabel: 'Jurisdicción',
                    xtype:"xcombo",
                    anchor: '96%',
                    displayField: 'Descripcion',
                    name: 'jurisdiccion',
                    typeAhead:true,
                    valueField: 'Id',
                    allowBlank: true,
                    msgTarget: 'under',
                    triggerAction: 'all',
                    autoLoad:true,
                    selectOnFocus:true,
                    forceSelection:true,
                    forceReload:true,
                    loadingText:"Cargando...",
                    lazyRender:true,
                    store:new Ext.data.JsonStore({
                       id:0,
                       url:"datagateway\/combolist\/model\/EntesRecaudadores\/m\/Base\/search\/Descripcion\/dir\/asc",
                       storeId:"EnteRecaudadorStore"
                    }),
                pageSize:20,
                editable:true,
                autocomplete:true
                },
                {
                    xtype:          'compositefield',
                    fieldLabel:     'Fecha de Ret/Perce ',
                    items: [
                        {xtype: 'displayfield', value: 'Desde:'},{name : 'fechadesde', xtype: 'xdatefield',format: 'd/m/Y',  dateFormat:'Y-m-d'},
                        {xtype: 'displayfield', value: 'Hasta:'},{name : 'fechahasta', xtype: 'xdatefield',format: 'd/m/Y',  dateFormat:'Y-m-d'},
                    ]
                },
                {
                    xtype: 'radiogroup',
                    fieldLabel: 'Formato',
                    width: 300,
                    items: [
                        { boxLabel: 'PDF', name: 'formato', inputValue: 'pdf', checked: true },
                        { boxLabel: 'Excel', name: 'formato', inputValue: 'xls' }
                    ]
                }
            ],
            buttons:[
                {
                    text:  'Ver Reporte',
                    handler: function () {
                        values = this.ownerCt.ownerCt.getForm().getValues();
                        var  params = '';

                        //values.conceptoretencion  = values.conceptoretencion.replace(/undefined/gi,"");
                        //values.conceptopercepcion = values.conceptopercepcion.replace(/undefined/gi,"");
                        values.tipodeconcepto     = values.tipodeconcepto.replace(/undefined/gi,"");
                        values.jurisdiccion       = values.jurisdiccion.replace(/undefined/gi,"");
                        values.fechadesde         = values.fechadesde.replace(/undefined/gi,"");
                        values.fechahasta         = values.fechahasta.replace(/undefined/gi,"");

                        console.log(values.conceptoretencion); 
                        console.log(values.conceptopercepcion);
                        console.log(values.tipodeconcepto);
                        console.log(values.jurisdiccion);
                        console.log(values.fechadesde);
                        console.log(values.fechahasta);
 
                        if (values.conceptoretencion || values.conceptopercepcion) {
                           if (values.conceptoretencion) {
                                params += '/conceptoretencion/'+values.conceptoretencion;
                           }
                           if (values.conceptopercepcion) {
                                params += '/conceptopercepcion/'+values.conceptopercepcion;
                           }
                        } else {
                            Ext.Msg.alert('Atencion', 'Debe seleccionar al menos un Concepto');
                            return;
                        }

                        if (values.tipodeconcepto) {
                            params += '/tipodeconcepto/'+values.tipodeconcepto;
                        } else {
                            Ext.Msg.alert('Atencion', 'Debe seleccionar al menos un Tipo de Concepto');
                            return;
                        }

                        if (values.jurisdiccion) {
                            params += '/jurisdiccion/'+values.jurisdiccion;
                        }

                        if(values.fechadesde == '' || values.fechahasta == '') {
                            Ext.Msg.alert('Atencion', 'Debe seleccionar un rango de fechas Desde/Hasta');
                            return;
                        } else {
                            params += '/fechadesde/'+values.fechadesde+'/fechahasta/'+values.fechahasta;
                        }

                        if (values.formato) {
                            params += '/formato/'+values.formato;
                        } else {
                            Ext.Msg.alert('Atencion', 'Debe seleccionar un Formato de Salida');
                            return;
                        }

                        app.publish('/desktop/modules/js/commonApps/showUrl.js', {
                            action: 'launch',
                            url: '/Contable/ReporteConceptosImpositivos/verreporte'+params,
                            width: 900,
                            height: 500,
                            title: 'Reporte ConceptosImpositivos'
                        });
                    }
                }
            ]
        };
    }
	
});

new Apps.<?=$this->name?>();
