<?php
use Rad\Util\FileExport;

/**
 * Base_ReporteChequesController
 *
 * Reporte con filtros de Cheques
 *
 * @copyright SmartSoftware Argentina
 * @package Aplicacion
 * @subpackage Base
 * @class Base_AdministrarVendedoresController
 * @extends Rad_Window_Controller_Action
 */
class Contable_ReporteLibroIvaController extends Rad_Window_Controller_Action {

    protected $title = 'Reporte Libro IVA';

    public function initWindow() {
        
    }

    protected function buildWhere($param) {
        $where = array();
        if ($param['libro']) {
            $where[] = "UnionLibroIVA.LibroIVA = {$param['libro']}";
        }
        if ( $param['tipo']) {
            $where[] = "UnionLibroIVA.TipoDeLibro = {$param['tipo']}";
        }

        $where = implode (' and ',$where);

        return $where;
    }

    public function verreporteAction() {
        $this->_helper->viewRenderer->setNoRender(true);

        $report = new Rad_BirtEngine();

        $rq = $this->getRequest();

        $db = Zend_Registry::get('db');

        $param['libro'] = $db->quote($rq->libro, 'INTEGER');
        $param['tipo'] = $db->quote($rq->tipo, 'INTEGER');
        $param['modelo'] = $db->quote($rq->modelo, 'INTEGER');

        $idLibro = '';

        if ($param['tipo'] == 1) {
            $tTipo = 'Compra';
            $Nombre = "COMPRAS";
        } else {
            $tTipo = 'Venta';
            $Nombre = "VENTAS";
        }

        if ($param['modelo'] == 6 || $param['modelo'] == 7 || $param['modelo'] == 8 || $param['modelo'] == 9) {

            // Exporto en formato CSV para la Afip
            $M = new Contable_Model_DbTable_LibrosIVA();
            // $parte: 1 Cabecera, 2 Alicuotas (Detalle)            
            $parte = ($param['modelo'] == 6 || $param['modelo'] == 8) ? 1 : 2;
            // $forma: 0 de ancho fijo, 1 separado por comas (0 es como pide Afip)            
            $forma = ($param['modelo'] == 6 || $param['modelo'] == 7) ? 0 : 1;
            // $alicuotas son los reportes de los detalles (7 y 9)
            $alicuota = ($param['modelo'] == 6 || $param['modelo'] == 8) ? "" : "_alicuotas";
            // $test para que en el nombre ponga test cuando no lo hagan como Afip pide
            $test = ($param['modelo'] == 6 || $param['modelo'] == 7) ? "" : "__TEST__";
            $datos = $M->exportadorAFIPres3685($param['libro'], $param['tipo'], $parte, $forma);

            $e = new FileExport(FileExport::MODE_SEPARATOR);
            $e->setLineEnd("\r\n");
            $e->addAll($datos);
            $contenido = str_replace("\r\n\r\n", "\r\n", $e->getContent());
            $R = $M->find($param['libro'])->current();
            $Nombre = "AFIPRes3685_" . $R->Anio . "-" . str_pad($R->Mes, 2, '0', STR_PAD_LEFT) . "_" . $test . $Nombre . $alicuota . "_" . date('YmdHis') . ".txt";
            header("Content-disposition: attachment; filename=$Nombre");
            header("Content-type: text/csv");
            echo $contenido;
        }

        // IVA Digital
        if ($param['modelo'] == 16 || $param['modelo'] == 17 || $param['modelo'] == 18 || $param['modelo'] == 19) {
            // Exporto en formato CSV para la Afip
            $M = new Contable_Model_DbTable_LibrosIVA();
            // $parte: 1 Cabecera, 2 Alicuotas (Detalle)
            $parte = ($param['modelo'] == 16 || $param['modelo'] == 18) ? 1 : 2;
            // $importacion: 0 No, 1 Si
            $importacion = ($param['modelo'] == 16 || $param['modelo'] == 17) ? 0 : 1;
            // $forma: 0 de ancho fijo, 1 separado por comas (0 es como pide Afip)
            $forma = ($param['modelo'] == 16 || $param['modelo'] == 17 || $param['modelo'] == 18 || $param['modelo'] == 19) ? 0 : 1;
            // $alicuotas son los reportes de los detalles (17 y 19)
            $txtalicuota = ($param['modelo'] == 16 || $param['modelo'] == 18) ? "" : "_alicuotas";
            $txtimportacion = ($param['modelo'] == 16 || $param['modelo'] == 17) ? "" : "_importacion";
            $datos = $M->exportadorAFIPres4597($param['libro'], $param['tipo'], $parte, $importacion, $forma);

            $e = new FileExport(FileExport::MODE_SEPARATOR);
            $e->setLineEnd("\r\n");
            $e->addAll($datos);
            $contenido = str_replace("\r\n\r\n", "\r\n", $e->getContent());
            $R = $M->find($param['libro'])->current();
            $Nombre = "AFIPRes4597_" . $R->Anio . "-" . str_pad($R->Mes, 2, '0', STR_PAD_LEFT) . "_" . $test . $Nombre . $txtimportacion . $txtalicuota . "_" . date('YmdHis') . ".txt";
            header("Content-disposition: attachment; filename=$Nombre");
            header("Content-type: text/csv");
            echo $contenido;
        }

        if ($param['modelo'] == 3 || $param['modelo'] == 4) {
            // Exporto en formato CSV para la Afip
            $M = new Contable_Model_DbTable_LibrosIVA();
            $datos = $M->exportadorAFIP($param['libro'], $param['tipo']);
            // La funcion ya controla traer contenido

            if ($param['modelo'] == 3) {
                // Valor absoluto, decimal con coma
                $formatoSalida = function($e) {
                    return str_replace('.', ',', abs($e));
                };
            } else {
                $Nombre = $Nombre . "__paraControl_NoValido_AFIP__";
                // desimal con coma
                $formatoSalida = function($e) {
                    return str_replace('.', ',', $e);
                };
            }

            $e = new FileExport(FileExport::MODE_SEPARATOR);
            $e->setLineFormat(array(
                'ImporteNetoGravado105' => array('format' => $formatoSalida),
                'ImporteNetoGravado210' => array('format' => $formatoSalida),
                'ImporteNetoGravado270' => array('format' => $formatoSalida),
                'ImporteIVA105' => array('format' => $formatoSalida),
                'ImporteIVA210' => array('format' => $formatoSalida),
                'ImporteIVA270' => array('format' => $formatoSalida),
                'ImporteImpuestosInternos' => array('format' => $formatoSalida),
                'ImporteConceptosExentosONoGravados' => array('format' => $formatoSalida),
                'ImportePercepcionesIVA' => array('format' => $formatoSalida),
                'ImporteOtrasPercepcionesImpuestosNacionales' => array('format' => $formatoSalida),
                'ImportePercepcionesImpuestosProvinciales' => array('format' => $formatoSalida),
                'ImportePercepcionesTasaMunicipales' => array('format' => $formatoSalida),
                'ImporteTotalComprobante' => array('format' => $formatoSalida)
                    )
            );
            $e->addAll($datos);

            $contenido = $e->getContent();

            $R = $M->find($param['libro'])->current();
            $Nombre = $Nombre . "_" . str_pad($R->Mes, 2, '0', STR_PAD_LEFT) . "_" . $R->Anio . ".CSV";

            header("Content-disposition: attachment; filename=$Nombre");
            header("Content-type: text/csv");
            echo $contenido;
        }

        if ($param['modelo'] == 1 || $param['modelo'] == 2 || $param['modelo'] == 5 ||
                $param['modelo'] == 10 || $param['modelo'] == 11 || $param['modelo'] == 12 ||
                $param['modelo'] == 13 || $param['modelo'] == 14
        ) {
            // Busco el nombre y tipo del Reporte para mostrarlo
            $M_L = new Contable_Model_DbTable_LibrosIVA();
            $R_L = $M_L->find($param['libro'])->current();
            if ($R_L) {
                $tPeriodo = $R_L->Descripcion;
            } else {
                $tPeriodo = 'Desconocido';
            }
            $texto = "Libro de IVA $tTipo periodo $tPeriodo";
            $idLibro = $param['libro'];
            $formato = ($rq->formato) ? $rq->formato : 'pdf';
            
            switch ($param['modelo']) {
                case 1:
                    $file = APPLICATION_PATH . "/../birt/Reports/Rep_LibrosIVA_clasico.rptdesign";
                    break;
                case 2:
                    $file = APPLICATION_PATH . "/../birt/Reports/Rep_LibrosIVA_conJurisdiccion.rptdesign";
                    break;
                case 5:
                    $file = APPLICATION_PATH . "/../birt/Reports/Rep_LibrosIVA_conPercepcionRetencion.rptdesign";
                    break;
                case 10:
                    $file = APPLICATION_PATH . "/../birt/Reports/Rep_LibrosIVA_conPlanDeCuenta.rptdesign";
                    break;
                case 11:
                    $idLibro = $param['libro'];
                    $file = APPLICATION_PATH . "/../birt/Reports/Rep_LibrosIVA_Retenciones_Percepciones.rptdesign";
                    break;
                case 12:
                    $formato = 'xls';
                    $file = APPLICATION_PATH . "/../birt/Reports/Exportador_Rep_LibrosIVA_Retenciones_Percepciones.rptdesign";
                    break;
                case 13:
                    $texto = "Detalle Libro de IVA $tTipo periodo $tPeriodo";
                    $formato = 'xls';
                    $report->setParameter('Libro', $param['libro'], 'Int');
                    $report->setParameter('TipoDeLibro', $param['tipo'], 'Int');
                    $file = APPLICATION_PATH . "/../birt/Reports/Exportador_Rep_LibrosIVA_Detalles.rptdesign";
                    break;
                case 14:
                    $formato = 'xls';
                    $texto = "Detalle Libro de IVA $tTipo periodo $tPeriodo con la Provincia";
                    $file = APPLICATION_PATH . "/../birt/Reports/Rep_LibrosIVA_conProvincia.rptdesign";
                    break;
            }

            $where = " WHERE " . $this->buildWhere($param);
            $report->renderFromFile($file, $formato, array(
                'TEXTO' => $texto,
                'WHERE' => $where,
                'IDLIBRO' => $idLibro,
                'TIPOLIBRO' => $param['tipo']
            ));

            $nombreRep = str_replace(array(" ", "/"), array("_", "-"), $texto);
            $NombreReporte = 'Reporte_' . $nombreRep . "_" . date('YmdHis');
            $report->sendStream($NombreReporte);
        }
    }
}
