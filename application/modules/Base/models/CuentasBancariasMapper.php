<?php

class Base_Model_DbTable_CuentasBancariasMapper extends Rad_Mapper
{
    protected $_class = 'Base_Model_DbTable_CuentasBancarias';

    /**
     * Anula un comprobante
     */


    /**
     * Cierra un comprobante
     */
    public function cerrar($id)
    {
        $this->_model->cerrar($id);
    }
}
