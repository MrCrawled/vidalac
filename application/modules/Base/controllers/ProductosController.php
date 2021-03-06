<?php
define('CAMPO_ENTERO',      1);
define('CAMPO_DECIMAL',     2);
define('CAMPO_FECHA',       3);
define('CAMPO_TEXTO',       4);
define('CAMPO_LISTA',       5);
define('CAMPO_BOLEANO',     6);
define('CAMPO_FECHAYHORA',  7);

/**
 * Base_ProductosController
 *
 * Productos
 *
 * @copyright SmartSoftware Argentina
 * @package Aplicacion
 * @subpackage Base
 * @class Base_ProductosController
 * @extends Rad_Window_Controller_Action
 */
class Base_ProductosController extends Rad_Window_Controller_Action
{

    protected $title = 'Productos';

    public function initWindow()
    {

        /**
         * Grilla CARACTERISTICAS
         */
        //$editors = $this->_getCaracteristicasEditors();

        $this->view->gridProductosCaracteristicas = "
            new Ext.grid.PropertyGrid ({
                id: '{$this->getName()}_GridProductosCaracteristicas',
                layout: 'fit',
                width: 300,
                customEditors: {$this->_getCaracteristicasEditors()},
                listeners: {
                    validateedit : function(e) {
                        var g = Ext.getCmp('{$this->getName()}_GridProductosGrillaDeCarga');
                        var selected = g.getSelectionModel().getSelected();
                        if (selected) {
                            Rad.callRemoteJsonAction ({
                                url: '/Base/Productos/saveproperty',
                                params: {
                                    property: e.record.id,
                                    value: e.value,
                                    id: selected.data.Id,
                                },
                                async: false,
                                success: function() {

                                },
                                failure: function (r) {
                                    e.record.data.value = e.originalValue;
                                    return true;
                                }
                            });
                        }
                    }
                }
            })";


        /**
         * Grilla PRODUCTOS
         */
        $config->id = $this->getName().'_GridProductosGrillaDeCarga';
        $config->abmWindowTitle = 'Productos';
        $config->abmWindowWidth = 800;
        $config->abmWindowHeight = 400;
        $config->iniSection = 'default';		
        $config->sm = new Zend_Json_Expr("
            new Ext.grid.RowSelectionModel ({
                singleSelect: true,
                listeners: {
                    rowselect: function(i,id, r) {
                        if (!r.data.Id) return;
                        Rad.callRemoteJsonAction ({
                            url: '/Base/Productos/getcaracteristicas',
                            params: {
                                id: r.data.Id,
                            },
                            success: function (response) {
                                g = Ext.getCmp('{$this->getName()}_GridProductosCaracteristicas');
                                g.setSource(response.data);
                            }
                        });
                    }
                }
            })
        ");

        $this->view->grid = $this->view->radGrid(
            'Base_Model_DbTable_Productos',
            $config,
            'abmeditor'
        );
    }

    protected function _getCaracteristicasEditors()
    {
        $modeloCaract = new Base_Model_DbTable_Caracteristicas(array(), false);

        $caracteristicas = $modeloCaract->fetchAll();
        $rtn = array();

        foreach ($caracteristicas as $k => $car) {

            switch ($car->TipoDeCampo) {
                case CAMPO_ENTERO:
                    $rtn[] = "'$car->Descripcion': new Ext.grid.GridEditor(new Ext.form.NumberField({selectOnFocus:true, decimalPrecision:0}))";
                    break;
                case CAMPO_DECIMAL:
                    $rtn[] = "'$car->Descripcion': new Ext.grid.GridEditor(new Ext.form.NumberField({selectOnFocus:true, decimalPrecision:6}))";
                    break;
                case CAMPO_FECHA:
                    $rtn[] = "'$car->Descripcion': new Ext.grid.GridEditor(new Ext.ux.form.XDateField({format:'d/m/Y'}))";
                    break;
                case CAMPO_BOLEANO:
                    $rtn[] = "'$car->Descripcion': new Ext.grid.GridEditor(
						new Ext.form.ComboBox({
						store: ['Si', 'No'],
						triggerAction: 'all',
						selectOnFocus:true
					}))";
                    break;
                case CAMPO_LISTA:

                    $lista = $car->findDependentRowset('Base_Model_DbTable_CaracteristicasListas');
                    $data = array();
                    foreach ($lista as $v) {
                        $data[] = ($v->Valor);
                    }

                    $store = json_encode($data);
                    $rtn[] = "'$car->Descripcion': new Ext.grid.GridEditor(
						new Ext.form.ComboBox({
						store: $store,
						typeAhead: true,
						triggerAction: 'all',
						selectOnFocus:true,
					}))";

                    break;
                case CAMPO_FECHAYHORA:
                    $rtn[] = "'$car->Descripcion':new Ext.grid.GridEditor( new Ext.ux.form.DateTime(new Ext.ux.form.XDateField({dateFormat:'d/m/Y', timeFormat: 'H:i:s'})))";
                    break;
            }
        }
        $rtn = implode(',', $rtn);
        return '{' . $rtn . '}';
    }

    public function getcaracteristicasAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
        $id = $request->id;
        try {
            $productos = new Base_Model_DbTable_Productos(array(), false);
            $producto = $productos->find($id)->current();

            if (!$producto)
                throw new Rad_Exception('No se encontro el producto');

            $db = $productos->getAdapter();


            $caract = $productos->getCaracteristicas($producto->Id);


            $dataf = array();
            foreach ($caract['campos'] as $k => $v) {
                $v['Valor'] = $caract['valores'][$v['Descripcion']];

                if ($v['Valor'] === null) {
                    $v['Valor'] = '';
                } else if ($v['TipoDeCampo'] == 3 || $v['TipoDeCampo'] == 7) {
                    $tmp = str_replace(array('-', ' ', ':'), ',', $v['Valor']);
                    $v['Valor'] = new Zend_Json_Expr("new Date($tmp)");
                }
                $dataf[$v['Descripcion']] = $v['Valor'];
            }

            echo "{success: true, data: " . Zend_Json::encode($dataf, false, array('enableJsonExprFinder' => true)) . "}";
        } catch (Rad_Db_Table_Exception $e) {
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

    public function savepropertyAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $request = $this->getRequest();
        $value = $request->value;
        $for = $request->id;
        $property = $request->property;

        try {
            $productos = new Base_Model_DbTable_Productos();
            $producto = $productos->find($for)->current();
            if (!$producto)
                throw new Rad_Exception('No se encontro el producto');

            $pccv = new Base_Model_DbTable_ProductosCategoriasCaracteristicasValores();
            $db = $pccv->getAdapter();
            //$value 	  = $db->quote($value);
            $for = $db->quote($for, 'INTEGER');
            //$property = $db->quote($property);

            $PCC = $db->fetchRow("
                SELECT PCC.Id, C.TipoDeCampo
                FROM Caracteristicas C
                join ProductosCategoriasCaracteristicas PCC on PCC.Caracteristica = C.Id AND C.Descripcion = '$property' AND PCC.ProductoCategoria = $producto->ProductoCategoria
            ");

            if (!$PCC) {
                throw new Rad_Exception('Esta característica no pertenece al producto');
            }

            $row = $pccv->fetchRow("Producto = $for and ProductoCategoriaCaracteristica = {$PCC['Id']}");
            if (!$row)
                $row = $pccv->createRow();

            //si es una Fecha acomodamos el valor
            if ($PCC['TipoDeCampo'] == 3 || $PCC['TipoDeCampo'] == 7) {
                $value = str_replace('T', ' ', $value);
            }

            $row->Producto = $for;
            $row->Valor = $value;
            $row->ProductoCategoriaCaracteristica = $PCC['Id'];
            $row->save();

            echo "{success: true}";
        } catch (Rad_Db_Table_Exception $e) {
            echo "{success: false, msg: '" . addslashes($e->getMessage()) . "'}";
        }
    }

}