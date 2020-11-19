<?php

class Contable_ReporteSicoreController extends Rad_Window_Controller_Action {

protected $title = 'Reporte Retenciones y Percepciones';

public function initWindow() {
    
}

public function verreporteAction() {
    $this->_helper->viewRenderer->setNoRender(true);

    $report = new Rad_BirtEngine();

    $rq = $this->getRequest();

    $db = Zend_Registry::get('db');
}