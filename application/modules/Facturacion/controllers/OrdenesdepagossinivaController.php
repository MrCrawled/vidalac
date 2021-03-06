<?php

/**
 * Facturacion_OrdenesDePagosSinIVAController
 *
 * Controlador de Ordenes de Pagos Sin IVA
 *
 * @package Aplicacion
 * @subpackage Facturacion
 * @class Facturacion_OrdenesDePagosSinIVAController
 * @extends Rad_Window_Controller_Action
 * @copyright SmartSoftware Argentina 2010
 */
class Facturacion_OrdenesDePagosSinIVAController extends Rad_Window_Controller_Action
{

    protected $title = "Comprobantes de Cancelacion Interno";
    
    /**
     * Inicializa la ventana del modulo
     */
    public function initWindow()
    {
        /**
         * Grilla principal
         */
        $parametrosAdc->abmWindowTitle = 'Comprobantes de Cancelacion Interno';
        $parametrosAdc->abmWindowWidth = 900;
        $parametrosAdc->abmWindowHeight = 500;
        $parametrosAdc->loadAuto = false;
        $parametrosAdc->abmForm = null; // Hacemos q no cree automaticamente el formulario

        $this->view->grid = $this->view->radGrid(
            "Facturacion_Model_DbTable_OrdenesDePagosSinIVA",
            $parametrosAdc,
            'abmeditor'
        );

         /**
         * Formulario Generador de cheques
         */
        $abmForm = new Zend_Json_Expr($this->view->radForm(
            'Base_Model_DbTable_GeneradorDeCheques', // Nombre del Modelo
            'datagateway',
            'generadorOP'
        ));
        $this->view->formGenCheques = $abmForm;

        /**
         * Formulario orden de pago (Paso 1)
         */
        $abmForm = new Zend_Json_Expr($this->view->radForm(
            'Facturacion_Model_DbTable_OrdenesDePagosSinIVA', // Nombre del Modelo
            'datagateway',
            'wizard'
        ));
        $this->view->form = $abmForm;

        /**
         * Grilla Asignar comprobantes a orden de pago (Paso 2)
         */

        $configHijaR1->loadAuto = false;
        $configHijaR1->withPaginator = false;
        $configHijaR1->id = 'VCSIArticulos_Rad_Hijad13d';
        $grillaHijaR1 = $this->view->radGrid(
            'Facturacion_Model_DbTable_ComprobantesSinIVAArticulos',
            $configHijaR1
        );

        $this->view->gridComprobantesArt = $grillaHijaR1;

        $detailGrid->id = 'VCSIArticulos_Rad_Hijad13d';
        $detailGrid->remotefield = 'Comprobante';
        $detailGrid->localfield = 'Id';

        $grillaAFC = $this->view->RadGridManyToMany(
            "Facturacion_Model_DbTable_ComprobantesSinIVA",
            "Facturacion_Model_DbTable_OrdenesDePagosSinIVAComprobantes",
            "Facturacion_Model_DbTable_OrdenesDePagosSinIVA",
            array(
                'title' => 'Comprobantes Sin IVA',
                'id'    => $this->getName() . '_GridComprobantesSinIVA',
                'xtype' => 'radformmanytomanyeditorgridpanel',
                'withPaginator' => false,
                'buildToolbar' => new Zend_Json_Expr('function(){}'), // saco la toolbar para no tener el boton
                'fetch' => 'AsociadosYFaltantesDePagar'
            ),
            'wizardOP'
        );

        $this->view->gridAFC = $grillaAFC;

        /**
         * 	Ordenes de Pagos Detalles (Pagos)
         */
        $config->withPaginator = false;
        $config->loadAuto = false;
        $config->ddGroup = 'pagos';
        $config->ddText = '{0} Pago(s) seleccionado(s)';
        $config->height = 300;
        $config->layout = 'fit';

        $grillaOdePD = $this->view->radGrid(
            'Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles',
            $config
        );
        $this->view->gridOPD = $grillaOdePD;
        unset($config);

        /**
         * Grilla Cheques
         */
        $config->title = 'Cheques';
        $config->loadAuto = false;
        $config->buildToolbar = new Zend_Json_Expr("function() {
            var id = this.getId();
            this.tbar = new Ext.Toolbar({
                items:[
                {
                    text:    'Generador',
                    icon: 	 'images/application_edit.png',
                    handler: function() {
                        this.parentModule.showGeneradorDeCheques();
                    },
                    scope: this
                },{
                    text:    'Cheques Propios',
                    icon:   'images/application_add.png',
                    handler: function() {
                        this.publish('/desktop/modules/Window/abm/index/m/Base/model/ChequesPropios', { action: 'launch' });
                    },
                    scope: this
                },
                {
                    text:    'Cheques de Terceros',
                    icon: 'images/application_form_add.png',
                    handler: function() {
                        this.publish('/desktop/modules/Window/abm/index/model/ChequesDeTerceros/m/Base', { action: 'launch' });
                    },
                    scope: this
                },
                {xtype:'tbseparator'},
                {
                    text:         'Ver De Terceros',
                    enableToggle: true,
                    icon:         'images/user_gray.png',
                    toggleHandler: function(btn, pressed){
                        if (pressed){
                            this.setPermanentFilter(0,'TipoDeEmisorDeCheque',2);
                        } else {
                            this.setPermanentFilter(0,'TipoDeEmisorDeCheque',1);
                        }
                        this.store.load();
                    },
                    scope: this
                }]
            });
        }");

        $config->viewConfig = new Zend_Json_Expr("
            {
                forceFit:true,
                enableRowBody:true,
                showPreview:true,
                getRowClass : function(record, rowIndex, p, store){
                    var fecha;
                    var numero;
                    if (record.data.FechaDeEmision) fecha = record.data.FechaDeEmision.dateFormat('d/m/Y');
                    else fecha = ' - ';
                    if (record.data.Numero) numero = record.data.Numero;
                    else numero = ' - ';

                    if(this.showPreview) {
                        p.body = '<p><b>Emision:</b> '+fecha+'   -   <b>Numero:  </b> '+numero+'</p>';
                        return 'x-grid3-row-expanded';
                    }
                    return 'x-grid3-row-collapsed';
                }
            }"
        );

        $config->ddText = '{0} Cheque(s) seleccionado(s)';
        $config->fetch = 'Disponibles';
        $cheques = $this->view->radGrid(
            'Base_Model_DbTable_Cheques',
            $config,
            null,
            'reducido'
        );
        $this->view->gridCheques = $cheques;
        unset($config);

        /**
         * 	Transferencias y depositos bancarios
         */
        $config->title = 'Transacciones';
        // Si se hacen cambios en Transferencias o en Depositos recargar
        $config->listeners = new Zend_Json_Expr("{
            render: function() {
                this.__suscribeToModelEvent('TransferenciasSalientes');
                this.__suscribeToModelEvent('DepositosSalientes');
                this.__suscribeToModelEvent('DebitoDirectoDeCuentaBancaria');
            }
        }");
        $config->buildToolbar = new Zend_Json_Expr("function() {
            var id = this.getId();
            this.tbar = new Ext.Toolbar({
                items:[{
                    text:     'Transferencias',
                    iconCls:  'add',
                    handler:  function() {
                        this.publish('/desktop/modules/Window/abm/index/m/Base/model/TransferenciasSalientes', { action: 'launch' });
                    },
                    scope:    this,
                },{
                    text:     'Depositos',
                    iconCls:  'add',
                    handler:  function() {
                        this.publish('/desktop/modules/Window/abm/index/m/Base/model/DepositosSalientes', { action: 'launch' });
                    },
                    scope:    this,
                },{
                    text:     'Debitos',
                    iconCls:  'add',
                    handler:  function() {
                        this.publish('/desktop/modules/Window/abm/index/m/Base/model/DebitoDirectoDeCuentaBancaria', { action: 'launch' });
                    },
                    scope:    this,
                }]
            });
        }");

        $config->ddText = '{0} Transaccion(s) seleccionada(s)';
        $config->fetch = 'NoUtilizadoDeSalida';
        $transaccionesBancarias = $this->view->radGrid(
            'Base_Model_DbTable_TransaccionesBancarias',
            $config,
            null,
            'salida'
        );
        $this->view->gridTranB = $transaccionesBancarias;
        unset($config);

        /**
         * Pagos con Tarjetas de Credito
         */
        $config->title = 'Tarjetas de Credito';
        // Si se hacen cambios en Transferencias o en Depositos recargar
        $config->listeners = new Zend_Json_Expr("{
            render: function() {
                this.__suscribeToModelEvent('TarjetasDeCreditoCuponesSalientes');
            }
        }");
        $config->buildToolbar = new Zend_Json_Expr("function() {
            var id = this.getId();
            this.tbar = new Ext.Toolbar({
                items:[{
                    text:     'Cargar Cupon',
                    iconCls:  'add',
                    handler:  function() {
                        this.publish('/desktop/modules/Window/abm/index/m/Facturacion/model/TarjetasDeCreditoCuponesSalientes', { action: 'launch' });
                    },
                    scope:    this,
                },{
                        text:     'Borrar Cupon',
                        iconCls:'remove',
                        handler: function() {
                                    this.deleteRows();
                                },
                    msg: '�Est� seguro que desea borrar los registros seleccionados?',

                    scope:    this,

                }]
            });
        }");

        $config->ddText    = '{0} Cupones(s) seleccionado(s)';
        $config->fetch     = 'NoUtilizadoDeSalida';
        $config->loadAuto  = false;
        $tarjetasDeCredito = $this->view->radGrid(
            'Facturacion_Model_DbTable_TarjetasDeCreditoCuponesSalientes',
            $config,
            null,
            'salida'
        );
        $this->view->gridCuponesTarjetas = $tarjetasDeCredito;
        unset($config);


    }




    /**
     * Agrega pagos con cheques
     */
    public function agregarchequeAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        $idDeCheques = $request->getParam('ids');

        try {
            $pagos = new Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles(array(), false);
            $respuesta = $pagos->insertPagosCheques($idOrdenDePago, $idDeCheques);
            $respuesta = json_encode($respuesta);
            echo "{success: true, pagos: $respuesta}";
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    /**
     * Agrega pagos con Notas de Credito
     */
    public function agregarnotaAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        $idDeNotas = $request->getParam('ids');

        try {
            $pagos = new Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles(array(), false);
            $respuesta = $pagos->insertPagosNotas($idOrdenDePago, $idDeNotas);
            $respuesta = json_encode($respuesta);
            echo "{success: true, pagos: $respuesta}";
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    /**
     * Agrega pagos efectivo
     */
    public function agregarefectivoAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        $monto = $request->getParam('monto');
        $caja = $request->getParam('caja');

        try {
            $pagos = new Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles(array(), false);
            $respuesta = json_encode($pagos->insertPagoEfectivo($idOrdenDePago, $monto, $caja));
            echo "{success: true, pagos: $respuesta}";
        } catch (Rad_Db_Table_Exception $e) {
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    /**
     * Agrega pagos con transferencia bancaria
     */
    public function agregartransaccionAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        $idTransacciones = $request->getParam('ids');

        try {
            $pagos = new Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles(array(), false);
            $respuesta = $pagos->insertPagosTransacciones($idOrdenDePago, $idTransacciones);
            $respuesta = json_encode($respuesta);
            echo "{success: true, pagos: $respuesta}";
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    /**
     * Agrega pagos con Tarjetas de Credito
     */
    public function agregarcupontarjetaAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request       = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        $idCupones     = $request->getParam('ids');

        try {
            $pagos     = new Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles;
            $respuesta = $pagos->insertPagosTarjeta($idOrdenDePago, $idCupones);
            $respuesta = json_encode($respuesta);
            echo "{success: true, pagos: $respuesta}";
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------------------------------------

    public function paso2Action()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        if (!$idOrdenDePago) {
            echo "{success: false, msg: 'Falta el parametro Id'}";
            return;
        }
        try {
            //controlo que el monto a pagar sea mayor a 0

            // ahora pueden venir valores negativos
            // $this->controlarMontoAPagar($idOrdenDePago);
            $db = Zend_Registry::get('db');

            $Comp_qSuma     = $db->fetchOne("SELECT fCompPago_Monto_qSuma($idOrdenDePago)");

            if ($Comp_qSuma < 0.01) {
                // Error no puede darse que nada sume
                throw new Rad_Db_Table_Exception("No se ha asignado ningun comprobante a pagar o ninguno de los comprobantes asignados suma.");
            } else {
                $Comp_qResta    = 0;
                $Comp_qResta    = $db->fetchOne("SELECT fCompPago_Monto_qResta($idOrdenDePago)");

                if ($Comp_qSuma > $Comp_qResta){
                    // Debo calcular el impuesto
                    $M_OP = new Facturacion_Model_DbTable_OrdenesDePagosSinIVA(array(), false);
                    $M_OP->insertarConceptosDesdeControlador($idOrdenDePago);
                }

            }

            echo '{success: true}';
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------------------------------------

    /**
     *  No se usa mas (contiene una vista que se elimino)
     * Controla que no permita seleccionar comprobantes quedando el monto a pagar en negativo
     *
     *  @param $idOrdenDePago 	Id del comprobante
     *
     */
    protected function controlarMontoAPagar($idOrdenDePago)
    {
        $M_CR = new Facturacion_Model_DbTable_ComprobantesRelacionados(array(), false);
        // busco los comprobantes hijos del comprobante padre.
        $R_CR = $M_CR->fetchAll("ComprobantePadre = $idOrdenDePago");

        $suma = 0;
        $resta = 0;
        //si tiene comprobante hijos los recorro uno a uno y calculo su monto
        if(!empty($R_CR)){
            foreach ($R_CR as $row) {
                $sql = "SELECT v.MontoTotal, v.TipoDeComprobante FROM
                        vComprobanteTotalPagado v where Id = ".$row->ComprobanteHijo;

                $db = $M_CR->getAdapter();
                $R_CRHMontos = $db->fetchRow($sql);

                //acumulo el monto del comprobante hijo en caso q sumo o reste
                if(in_array($R_CRHMontos["TipoDeComprobante"], array(24,25,26,27,28,33,34,35,36,37,38,39,40))){
                    $resta += $R_CRHMontos["MontoTotal"];
                } else {
                    $suma += $R_CRHMontos["MontoTotal"];
                }
            }
            //pregunto que si lo q suma es menor o igual a lo q resta tiro una excepcion
            if($suma < $resta){
                throw new Rad_Db_Table_Exception("El monto a pagar debe ser mayor o igual a 0 (cero).");
            }
        }
    }


    // ---------------------------------------------------------------------------------------------------------------------------------------------------

    public function agregarfacturaAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');
        $idDeFacturas = $request->getParam('ids');

        try {
            $pagos = new Facturacion_Model_DbTable_OrdenesDePagosSinIVADetalles(array(), false);
            $respuesta = $pagos->insertPagosFacturas($idOrdenDePago, $idDeFacturas);
            $respuesta = json_encode($respuesta);
            echo "{success: true, pagos: $respuesta}";
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------------------------------------

    public function getmontototalAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');

        try {
            $ordenes = new Facturacion_Model_DbTable_OrdenesDePagosSinIVA(array(), false);
            $orden = $ordenes->find($idOrdenDePago)->current();
            if (!$orden) {
                throw new Rad_Exception('No se encontro el comprobante de cancelaci�n interno.');
            }
            echo "{success: true, monto: '$orden->MontoTotal'}";
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    public function insertarconceptosasociadosAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');

        try {
            $M_OPC = new Facturacion_Model_DbTable_OrdenesDePagosSinIVAConceptos(array(), false);
            $M_OPC->insertarConceptosDesdeControlador($idOrdenDePago);
            echo '{success: true}';
        } catch (Rad_Db_Table_Exception $e) {
            //error_log($e->getMessage());
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    public function pagarordendepagoAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $M_OrdenesDePagosSinIVA = new Facturacion_Model_DbTable_OrdenesDePagosSinIVA(array(), false);
        $request = $this->getRequest();
        $idOrdenDePago = $request->getParam('idOrdenDePago');

        try {
            $M_OrdenesDePagosSinIVA->cerrar($idOrdenDePago);

            echo '{success: true}';
        } catch (Rad_Db_Table_Exception $e) {
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------------------------------------
}

