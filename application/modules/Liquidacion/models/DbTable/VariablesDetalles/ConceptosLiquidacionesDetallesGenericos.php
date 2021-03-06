<?php
require_once 'Rad/Db/Table.php';

/**
 * Liquidacion_Model_DbTable_VariablesDetalles_ConceptosLiquidacionesDetallesGenericos
 *
 * Conceptos Liquidaciones Detalles Genericos
 *
 * @copyright SmartSoftware Argentina
 * @package Aplicacion
 * @subpackage Liquidacion
 * @class Liquidacion_Model_DbTable_VariablesDetalles_ConceptosLiquidacionesDetallesGenericos
 * @extends Liquidacion_Model_DbTable_VariablesDetalles_ConceptosLiquidacionesDetalles
 */
class Liquidacion_Model_DbTable_VariablesDetalles_ConceptosLiquidacionesDetallesGenericos extends Liquidacion_Model_DbTable_VariablesDetalles_ConceptosLiquidacionesDetalles
{

    protected $_referenceMap    = array(
        'Variables' => array(
            'columns'           => 'Variable',
            'refTableClass'     => 'Liquidacion_Model_DbTable_Variables_ConceptosLiquidaciones',
            'refJoinColumns'    => array('Descripcion'),
            'comboBox'          => true,
            'comboSource'       => 'datagateway/combolist',
            'refTable'          => 'Variables',
            'refColumns'        => 'Id',
            'comboPageSize'     => 10
        )
    );

    protected $_permanentValues = array(
        'VariableJerarquia' => 6
    );

    protected $_defaultValues = array(
        'Convenio' => null,
        'Empresa' => null,
        'ConvenioCategoria' => null,
        'GrupoDePersona' => null,
        'Servicio' => null
    );

    /**
     * Jerarquia que afecta una modificacion realizada desde este modelo
     */
    protected $_logLiquidcionJerarquia = 6; // 6: Generico... afecta a todos

}