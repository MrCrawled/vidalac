Ext.ns( 'Apps' );

Apps.<?=$this->name?> = Ext.extend(RadDesktop.Module, {
	autoStart: true,
	title: '<?=$this->title?>',
    /**
	* Aqui se agregan los js de los que depende este modulo
	* estos se cargaran automaticamente antes de ejecutarse
	*/
//	requires: [
//        '/js/debug.js'
//    ],

	/**
	* Siempre debe terminar sin / por ejemplo /desktop/modules/window/mimodulo
	*/
	appChannel: '/desktop/modules<?=$_SERVER['REQUEST_URI']?>',

	
	/**
    * Se ejecuta cuando recibe el evento launch 
	* 
	* se puede capturar otros eventos agregando 
	* funciones con la nomenclatura eventMifuncion
	* por ejemplo eventSearch: function(ev){}
	*/
    eventlaunch: function(ev) {
		this.createWindow();
    },

    /**
	* Filtra la grilla por el id enviado
	*/
	eventfind: function (ev) {
		this.createWindow();
		var params = this.grid.buildFilter(0,'Id',ev.value);
		this.grid.store.load(params);
	},

    createWindow: function() {
        var win = app.desktop.getWindow(this.id+'-win');
        if ( !win ) {
			this.gridAnalisisProt = Ext.ComponentMgr.create(<?=$this->gridAnalisisProt?>);
            this.grid = Ext.ComponentMgr.create(<?=$this->grid?>);
            win = this.create();
		}
        win.show();
    },


    create: function() {
        return app.desktop.createWindow({
            id: this.id+'-win',
            title: this.title,
            width: 900,
            height: 400,
            iconCls: 'icon-grid',
            border: false,
            shim:   false,
            animCollapse: false,
            layout: 'fit',
            items: [
                {
                    xtype : 'panel',
                    layout : "border",
                    items : [
                        {
                            region : "center",
                            title : "Analisis",
                            layout: 'fit',
                            items : [
                                this.gridAnalisisProt
                            ]
                        },
                        {
                            region : "west",
                            title : "Muestras",
                            layout: 'fit',
                            width : 500,
                            split : true,
                            items : [
                                this.grid
                            ]
                        }
                    ]
                }
            ]
        });
    }
});

new Apps.<?=$this->name?>();
