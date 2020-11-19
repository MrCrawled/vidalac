<?php

class Contable_ReporteRetencionesController extends Rad_Window_Controller_Action {

protected $title = 'Reporte Retenciones';

public function initWindow() {
    
}

public function verreporteAction() {
    $this->_helper->viewRenderer->setNoRender(true);

    $report = new Rad_BirtEngine();

    $rq = $this->getRequest();

    $db = Zend_Registry::get('db');
}
}