<?php

class Facturacion_Model_OrdenesDePagosMapper extends Rad_Mapper
{
    protected $_class = 'Facturacion_Model_DbTable_OrdenesDePagos';
  
    public function anular ($id)
    {
        $this->_model->anular($id);
    }
  
    public function getTotal($id)
    {
        return $this->_model->recuperarMontoaPagar($id);
    }
    
    public function getTotalRetenciones($id)
    {
        return $this->_model->recuperarMontoTotalRetenciones($id);
    }
    
    public function getTotalRetencionesIB($id)
    {
        return $this->_model->recuperarMontoTotalRetencionesIB($id);
    }
    
    public function getTotalRetencionesGanancias($id)
    {
        return $this->_model->recuperarMontoTotalRetencionesGanancias($id);
    }
    
    public function getControlTotalConcepto($id)
    {
        //funcion que controla q el total del concepto sea mayor
        $M_OPC = new Facturacion_Model_DbTable_ComprobantesImpositivos(array(), false);
        $M_OPC->controlTotalConcepto($id);
    }
        
    public function cambiarImputacionIva($idComprobante, $IdLibroIVA){
        $this->_model->cambiarImputacionIVA($idComprobante, $IdLibroIVA);
    }
    
}
