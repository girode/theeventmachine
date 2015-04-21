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
        
        
//        $this->widgetSchema->addFormFormatter('bt_two_cols', new sfWidgetFormSchemaFormatterBootstrapRequiredInTwoCols($this->widgetSchema));
//        $this->widgetSchema->setFormFormatterName('bt_two_cols');
        
        $this->widgetSchema->addFormFormatter('aaa', new sfWidgetFormSchemaFormatterBootstrapRequiredInTwoCols($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('aaa');
        
    }
    
//    public function getFieldsByRequired() {
//        
//    }
    
    public function renderRequiredFields(){
        $output = '';
        $fields = $this->getRequiredFields();
        
        $requiredFields = $fields['required'];
                
        foreach($this as $k => $field){
            if($field instanceof sfFormFieldSchema || $field->isHidden()){
                continue;
            }
                         
            $widgetName = $this->widgetSchema->generateName($k);
            if(in_array($widgetName, $requiredFields)) $output .= $field->renderRow();
        }

        return $output;
    }
    
    protected function generateCheckboxes($checkBoxes = array()) {
        $retStr = '<div class="form-group">'. '<div class="col-sm-7 col-sm-offset-5">';
        
        foreach($checkBoxes as $checkBox){
            $name = $this->getWidgetSchema()->generateName($checkBox['name']);
            
            $retStr .= "<label class=\"checkbox-inline\" for=\"".  $checkBox['widget']->generateId($name) ."\">".
                           $this[$checkBox['name']]. ' ' . $checkBox['name'] . 
                       "</label>";
        }
        
        $retStr .= "</div>" . "</div>";
        
        return $retStr;
    }
    
    public function renderNonRequiredFields(){
        $output = '';
        $fields = $this->getRequiredFields();
        $checkBoxes = array();
        
        $nonRequiredFields = $fields['non_required'];
                
        foreach($this as $k => $field){
            if($field instanceof sfFormFieldSchema || $field->isHidden()){
                continue;
            }
            
            $widget = $field->getWidget();
            if($widget instanceof sfWidgetFormInputCheckbox){
                $checkBoxes[] = array(
                    'name'   => $k,
                    'widget' => $widget
                );
                continue;
            }
            
            $widgetName = $this->widgetSchema->generateName($k);
                         
            if(in_array($widgetName, $nonRequiredFields)) $output .= $field->renderRow();
        }
        
        // genero los widget de checkbox de otra manera
        $output .= $this->generateCheckboxes($checkBoxes); 
        
        return $output;
    }
    
    

}
