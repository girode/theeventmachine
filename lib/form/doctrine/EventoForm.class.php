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
        $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea();
        $this->widgetSchema['inicio']      = new sfWidgetFormBootstrapDatePicker();
        $this->widgetSchema['fin']         = new sfWidgetFormBootstrapDatePicker();
        
        $datePattern = '/^(?P<day>\d{2})\/(?P<month>\d{2})\/(?P<year>\d{4})';
        $timePattern = '(?P<hour>\d{1,2}):(?P<minute>\d{2})(:(?P<second>\d{2}))?$/'; 
                
        $pattern =  $datePattern. ' ' .$timePattern;

        $this->validatorSchema['inicio']->setOption('date_format', $pattern);
        $this->validatorSchema['fin']->setOption('date_format', $pattern);
        
    }
    
    public function configure() {
        parent::configure();
        unset($this['id']);
        
        if($this->getOption('usuario-simple')){
            unset($this['agendas_list']);
        }
        
        $this->configurarWidgets();
        $this->widgetSchema->setPositions(array(
            'titulo',        
            'descripcion',   
            'inicio',        
            'fin', 
            'url',           
            'diario',        
            'repetir',       
            'editable',
        ));
        
        
        $this->widgetSchema->addFormFormatter('bootstrap', new sfWidgetFormSchemaFormatterTwitterBootstrap($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('bootstrap');
        
    }

}
