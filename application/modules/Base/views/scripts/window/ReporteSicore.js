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
            url : '/Base/ReporteSicore/verreporte',
            layout: 'form',
            border: false,
            bodyStyle: 'padding:10px',
            defaults: {
                border: false
            },
            items: [
                {
                    xtype:          'compositefield',
                    fieldLabel:     'Fecha',
                    items: [
                        {xtype: 'displayfield', value: 'Desde:'},{name : 'fechaDesde', xtype: 'xdatefield',format: 'd/m/Y',  dateFormat:'Y-m-d'},
                        {xtype: 'displayfield', value: 'Hasta:'},{name : 'fechaHasta', xtype: 'xdatefield',format: 'd/m/Y',  dateFormat:'Y-m-d'},
                    ]
                } 
             ],
            buttons:[
                {
                    text:  'Ver Reporte',
                    handler: function () {
                        values = this.ownerCt.ownerCt.getForm().getValues();
                        var  params = '';

                        values.fechaDesde    = values.fechaDesde.replace(/undefined/gi,"");
                        values.fechaHasta    = values.fechaHasta.replace(/undefined/gi,"");

                        if(values.fechaDesde == '' && values.fechaHasta == '' && values.libroIvaDesde == '' && values.libroIvaHasta == '') {
                          Ext.Msg.alert('Atencion', 'Debe seleccionar un rango de fechas Desde/Hasta o un periodo Libro IVA Desde/Hasta');
                          return;
                        }
                  
                 
                        if (values.fechaDesde != '' && values.fechaDesde) {
                            params += '/fechadesde/'+values.fechaDesde;
                        }
 
                        if (values.fechaHasta != '' && values.fechaHasta) {
                            params += '/fechahasta/'+values.fechaHasta;
                        }

                        app.publish('/desktop/modules/js/commonApps/showUrl.js', {
                            action: 'launch',
                            url: '/Base/ReporteSicore/verreporte'+params,
                            width: 900,
                            height: 500,
                            title: 'Reporte Sicore'
                        });
                    }
                }
            ]
        };
    }
	
});

new Apps.<?=$this->name?>();
