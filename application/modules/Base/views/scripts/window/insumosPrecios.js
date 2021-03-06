Ext.ns( 'Apps' );

Apps.<?=$this->name?> = Ext.extend(RadDesktop.Module, {
    autoStart: true,
    title: '<?=$this->title?>',
    appChannel: '/desktop/modules<?=$this->url()?>',
	
    eventfind: function(ev) {
        this.createWindow();
        var p = this.grid.buildFilter(0, 'Id', ev.value);
        this.grid.store.load({params:p});
    },
	
    eventsearch: function(ev) {
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
            this.grid = Ext.ComponentMgr.create(<?=$this->grid?>);
            win = this.create();
        }
        win.show();
    },
	
    create: function() {
        this.createSecGrids();
        defaultWinCfg = {
            id: this.id+'-win',
            title: this.title,
            iconCls: 'icon-grid',
            border:  false,
            shim: false,
            animCollapse: false,
            layout: 'fit',
            width: 1000,
            height:500,
            items: [
                this.renderWindowContent()
            ]
        };
        return app.desktop.createWindow(defaultWinCfg);
    },
	
    renderWindowContent: function ()
    {
        return {
            layout: 'border',
            defaults: { layout: 'fit', border: false },
            items: [
                {
                    region: 'center',
                    items: this.grid
                },
                {
                    region: 'east',
                    width: 400,
                    items: [
                        {
                            layout: {
                                type: 'vbox',
                                align: 'stretch'
                            },
                            //height: 600,
                            items: [
                                this.gridPLDP,
                                this.gridPLDP_Informados
                                //this.gridPLDP_Historicos
                            ]
                        }
                    ]
                }
            ]
        };
    },
	
    createSecGrids: function ()
    {
        this.gridPLDP = Ext.ComponentMgr.create(<?php echo $this->gridPLDP ?>);
        this.gridPLDP_Informados = Ext.ComponentMgr.create(<?php echo $this->gridPLDP_Informados ?>);
        //this.gridPLDP_Historicos = Ext.ComponentMgr.create(<?php echo $this->gridPLDP_Historicos ?>);
    }
	
});

new Apps.<?=$this->name?>();
