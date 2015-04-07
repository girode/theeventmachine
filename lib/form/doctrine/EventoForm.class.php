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

    public function configure() {
        parent::configure();
        
        if($this->getOption('usuario-simple')){
            unset($this['agendas_list']);
        }
        
        $this->widgetSchema->addFormFormatter('bootstrap', new sfWidgetFormSchemaFormatterTwitterBootstrap($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('bootstrap');
        
    }

}
