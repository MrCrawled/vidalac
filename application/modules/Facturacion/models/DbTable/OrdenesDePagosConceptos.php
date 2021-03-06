<?php

class Facturacion_Model_DbTable_OrdenesDePagosConceptos extends Facturacion_Model_DbTable_ComprobantesImpositivos {

    public function init() {
        $this->_referenceMap['ConceptosImpositivos']['comboSource'] = 'datagateway/combolist/fetch/ParaPagos';
        $this ->_validators = array(
            'ConceptoImpositivoPorcentaje'=> array(
                array( 'GreaterThan',0),
                'messages' => array('La cantidad no puede ser 0 (cero)')
            ),
            'MontoImponible'=> array(
                array('GreaterThan',0),
                'messages' => array('El Monto Imponible no puede ser 0 (cero)')
            ),
            'Monto'=> array(
                array('GreaterThan',0),
                'messages' => array('El Monto no puede ser 0 (cero)')
            )
        );
        parent::init();
    }


    /**
     * 	Insert
     *
     * @param array $data 	Valores que se insertaran
     *
     */
    public function insert($data) {
        $this->_db->beginTransaction();
        try {
           
            $this->salirSi_estaCerrado($data['ComprobantePadre']);
            
            // Salgo si la FC no es A o M o en el caso de los pagos o cobros existe una factura que no sea A o M
            $M_CP = new Facturacion_Model_DbTable_ComprobantesPagos(array(), false);
            $M_C = new Facturacion_Model_DbTable_Comprobantes(array(), false);
            $M_C->salirSi_NoEsComprobanteAoM($data['ComprobantePadre']);
            
            // controlo que el concepto no este asignado ya
            $this->salirSi_estaElConceptoAsignado($data['ComprobantePadre'], $data['ConceptoImpositivo']);
           
            // Recupero el tipo de comprobante que se trata
            $ImputacionFiscal = $this->recuperarImputacionFiscalDelComprobante($data['ComprobantePadre']);

            if ($this->esIVA($data['ConceptoImpositivo'])) {
                switch ($ImputacionFiscal) {
                    case 'CreditoFiscal' : $data['TipoDeComprobante'] = 10;
                        break;
                    case 'DebitoFiscal' : $data['TipoDeComprobante'] = 11;
                        break;
                }
            } else {
                switch ($ImputacionFiscal) {
                    case 'CreditoFiscal' : $data['TipoDeComprobante'] = 12;
                        break;
                    case 'DebitoFiscal' : $data['TipoDeComprobante'] = 13;
                        break;
                }
            }

            // Completo los datos que faltan a partir del padre
            $R_C_P = $M_C->find($data['ComprobantePadre'])->current();
            if (!$R_C_P) {
                throw new Rad_Db_Table_Exception("No se puede localizar el comprobante padre.");
            }
            // Recupero el Monto Imponible del Comprobate Padre
            $MontoImponible = $M_CP->recuperarMontoImponiblePagosyCobros($data['ConceptoImpositivo'], $data['ComprobantePadre']);
            
            $data['MontoImponible'] = $MontoImponible;
            
            $data['Persona'] = $R_C_P->Persona;
            $data['LibroIVA'] = $R_C_P->LibroIVA;

            // De no venir el porcentaje lo busco
            if (!$data["ConceptoImpositivoPorcentaje"]) {
                $data['ConceptoImpositivoPorcentaje'] = $this->recuperarPorcentajeConcepto($data['Persona'], $data['ConceptoImpositivo']);
            }
            
           // $data['FechaEmision'] = date('Y-m-d');

            // Aunque no quede monto Imponible inserto igual
            if ($MontoImponible > 0.00001) {
                $data['Monto'] = $MontoImponible * $data["ConceptoImpositivoPorcentaje"] / 100;
            } else {
                $data['Monto'] = 0;
            }

            // Indico que se cargo manualmente
            $data['Modificado'] = 1;

            /**
             * CAMBIE PARENT:: POR RAD_DB_TABLE: MARTIN
             */
            $id = Rad_Db_Table::insert($data);
            $this->reasignarCIcomoFormaDePago($data['ComprobantePadre'], $id, $data['Monto']);

            $this->_db->commit();
            return $id;
        } catch (Exception $e) {
            $this->_db->rollBack();
            throw $e;
        }
    }

    /**
     * 	Update
     *
     * @param array $data 		Valores que se cambiaran
     * @param array $where 	Registros que se deben modificar
     *
     */
    public function update($data, $where) {

        if ( $data['ConceptoImpositivoPorcentaje'] == null && $data['MontoImponible'] == null && $data['Monto'] == null ) {
           return;
        }

        $this->_db->beginTransaction();
        try {

            // Mapeo el $data con los campos que se pueen modificar a variables
            $gPorcentaje = $data['ConceptoImpositivoPorcentaje'];
            $gMonto = $data['Monto'];
            $gMontoImponible = $data['MontoImponible'];
            $M_C = new Facturacion_Model_DbTable_Comprobantes(array(), false);
            $M_CP = new Facturacion_Model_DbTable_ComprobantesPagos(array(), false);

            $reg = $this->fetchAll($where);

            if (!count($reg)) {
                throw new Rad_Db_Table_Exception("No se puede localizar el registro a modificar.");
            }

            if ( $data['ConceptoImpositivoPorcentaje'] == null ) {
                  $data['ConceptoImpositivoPorcentaje'] = $reg[0]->ConceptoImpositivoPorcentaje;
                  $gPorcentaje = $data['ConceptoImpositivoPorcentaje'];
            }

            if ( $data['MontoImponible'] == null ) {
                  $data['MontoImponible'] = $reg[0]->MontoImponible;
                  $gMontoImponible = $data['MontoImponible'];
            }

            if ( $data['Monto'] == null ) {
                  $data['Monto'] = $reg[0]->Monto;
                  $gMonto = $data['Monto'];
            }

            // Controles
            foreach ($reg as $row) {
                $this->salirsi_estaCerrado($row->Id);
                $this->salirSi_estaCerrado($row->ComprobantePadre);

                // Que no modifique la persona del comprobante impositivo
                if (isset($data['ComprobantePadre']) && $data['ComprobantePadre']) {
                    throw new Rad_Db_Table_Exception("No se puede modificar la asignacion del comprobante Impositivo.");
                }
                // Que no modifique el concepto impositivo
                if (isset($data['ConceptoImpositivo']) && $data['ConceptoImpositivo'] != $row->ConceptoImpositivo) {
                    throw new Rad_Db_Table_Exception("No se puede modificar el Concepto Impositivo. De ser necesario eliminelo e ingreselo correctamente.");
                }
                // Que en el caso de los IVA no modifique el porcentaje
                if ($gPorcentaje && $gPorcentaje != $row->ConceptoImpositivoPorcentaje &&
                        $this->esIVA($row->ConceptoImpositivo)) {
                    throw new Rad_Db_Table_Exception("No se puede modificar el porcentaje de IVA.");
                }
            }

            // updateo y publico
            foreach ($reg as $row) {

                $whereRow = "$this->_name.Id = " . $row->Id;
                // Si se borro el porcentaje busco el que corresponda
                if (!$gPorcentaje) {
                    $data["ConceptoImpositivoPorcentaje"] = $this->recuperarPorcentajeConcepto($row->Persona, $row->ConceptoImpositivo);
                    $gPorcentaje = $data["ConceptoImpositivoPorcentaje"];
                    Rad_Log::debug("gP1: $gPorcentaje");
                }

                // Si cambio el porcentaje y no se indico el monto o no se modifico, recalculo el monto
                if ($gPorcentaje != $row->ConceptoImpositivoPorcentaje) {
                    // Si cambio el porcentaje pero no cambio el monto --> recalculo el monto
                    if (!$gMonto || ($gMonto && $gMonto == $row->Monto)) {
                        
                        $MontoImponible = $M_CP->recuperarMontoImponiblePagosyCobros($row->ConceptoImpositivo, $row->ComprobantePadre);
                        $data['Monto'] = $MontoImponible * $gPorcentaje / 100;
                        $data['MontoImponible'] = $MontoImponible;
                        Rad_Log::debug("gM1:". $data['Monto']);
                        Rad_Log::debug("gMI1:". $data['MontoImponible']);
                    } 
                } else {
                    // Si no cambio el porcentaje y no cambio el monto uso el valor ingresado
                    if (!$gMonto || ($gMonto && $gMonto == $row->Monto)) {
                        // Recupero el Monto Imponible del Comprobate Padre
                        $MontoImponible = $M_CP->recuperarMontoImponiblePagosyCobros($row->ConceptoImpositivo, $row->ComprobantePadre);
                        $data['Monto'] = $MontoImponible * $gPorcentaje / 100;
                        $data['MontoImponible'] = $MontoImponible;
                        Rad_Log::debug("gM2:". $data['Monto']);
                        Rad_Log::debug("gMI2:". $data['MontoImponible']);
                    }
                }
                   if ($gMontoImponible != $row->MontoImponible) {                 
                    if (!$gMonto || ($gMonto && $gMonto == $row->Monto)) {
                        
                        $data['Monto'] = $gMontoImponible * $gPorcentaje / 100;
                        $data['MontoImponible'] = $gMontoImponible;
                        Rad_Log::debug("gM1:". $data['Monto']);
                        Rad_Log::debug("gMI1:". $data['MontoImponible']);
                    } 
                }
                
                $data['Modificado'] = 1;
                /**
                 * CAMBIE PARENT:: POR RAD_DB_TABLE: Pablo... se deberian mover las funciones del CI a FacturasXXConceptos
                 */               
                Rad_Db_Table::update($data, $whereRow);
                $this->reasignarCIcomoFormaDePago($row->ComprobantePadre, $row->Id, $data['Monto']);
            }

            $this->_db->commit();
        } catch (Exception $e) {
            $this->_db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Delete
     *
     * @param array $where 	Registros que se deben eliminar
     *
     */
    public function delete($where)
    {
        try {
            $this->_db->beginTransaction();
            $R_CI = $this->fetchAll($where);

            if (count($R_CI)) {
                $M_CP = new Facturacion_Model_DbTable_ComprobantesPagos(array(), false);			
                $M_C = new Facturacion_Model_DbTable_Comprobantes(array(), false);

                foreach ($R_CI as $row) {
                    // Verificar si el padre esta cerrado
                    $M_C->salirSi_estaCerrado($row->ComprobantePadre);
                    // Borro los registros del Detalle
                    $M_CP->eliminarDetalleComprobanteRelacionado($row->Id);
                    // Publico y Borro
                    Rad_PubSub::publish('OPC_preBorrar', $row);
                    parent::delete('Comprobantes.Id =' . $row->Id);
                    Rad_PubSub::publish('OPC_posBorrar', $row);
                }
            }
            $this->_db->commit();
            return true;
        } catch (Exception $e) {
            $this->_db->rollBack();
            throw $e;
        }
    }
}
