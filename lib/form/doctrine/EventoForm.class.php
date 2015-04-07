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
        
        $years = range(2009, 2020);
        
        $this->widgetSchema['inicio'] = new sfWidgetFormDate(array(
            'format' => '%day%/%month%/%year%',
            'years' => array_combine($years, $years)
        ));
        
        $this->widgetSchema['fin'] = new sfWidgetFormDate(array(
            'format' => '%day%/%month%/%year%',
            'years' => array_combine($years, $years)
        ));
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
