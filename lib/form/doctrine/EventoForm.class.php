<?php

/**
 * Evento form.
 *
 * @package    theeventmachine
 * @subpackage form
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventoForm extends BaseEventoForm {

    
    protected function configurarWidgets() {
        $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea(array(), array('cols' => 25, 'rows' => 5));
        
//        $years = range(2009, 2020);
        
//        $this->widgetSchema['inicio'] = new sfWidgetFormDate(array(
//            'format' => '%day%/%month%/%year%',
//            'years' => array_combine($years, $years)
//        ));
//        
//        $this->widgetSchema['fin'] = new sfWidgetFormDate(array(
//            'format' => '%day%/%month%/%year%',
//            'years' => array_combine($years, $years)
//        ));
        
        $this->widgetSchema['inicio'] = new sfWidgetFormBootstrapDatePicker();
        $this->widgetSchema['fin']    = new sfWidgetFormBootstrapDatePicker();
        
        
        $a = new sfValidatorDate();
                
        $pattern = '/^(?:\d{2})\/(?:\d{2})\/(?:\d{4}) (?:\d{1,2}):(?:\d{2})$/';
//        $pattern = '/^(?P<day>\d{2})\/(?P<month>\d{2})\/(?P<year>\d{4}) (?P<hour>\d{2})\/(?P<minute>\d{2})\/(?P<second>\d{4}) $/';
        
        $this->validatorSchema['inicio']->setOption('date_format', $pattern);
        $this->validatorSchema['fin']->setOption('date_format', $pattern);
        
    }
    
    public function configure() {
        parent::configure();
        
        if($this->getOption('usuario-simple')){
            unset($this['agendas_list']);
        }
        
        $this->configurarWidgets();
        $this->widgetSchema->setPositions(array(
            'titulo',        
            'descripcion',   
            'inicio',        
            'fin',           
            'identificador', 
            'url',           
            'diario',        
            'repetir',       
            'editable',
            'id',
        ));
        
        
        $this->widgetSchema->addFormFormatter('bootstrap', new sfWidgetFormSchemaFormatterTwitterBootstrap($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('bootstrap');
        
    }

}
