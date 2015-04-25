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

    protected $helpPrefix = 'help_'; 
    
    
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
        
        $this->widgetSchema->setHelps(array(
            'titulo' => 'Ingrese el titulo del evento',
            'descripcion' => 'Ingrese la descripcion del evento',   
            'inicio' => 'Ingrese la fecha de inicio del evento',        
            'fin' => 'Ingrese la fecha de fin del evento', 
            'url'=> 'Ingrese una URL asociada al evento',           
            'diario' => 'Si el evento ocurre durante el dia en vez de a una hora especifica, marque aquí',        
            'repetir' => 'Si el evento se repite marque este checkbox',       
            'editable' => 'Si el evento es editable, por favor tilde la marca',
        ));
        
        $this->widgetSchema->addFormFormatter('aaa', new sfWidgetFormSchemaFormatterBSEventoForm($this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('aaa');
        
    }
    
    private function fillHelpId($field, $row){
        return strtr($row, array(
            '%help_field_id%' => $this->helpPrefix . $field->renderId(),
        ));
    }
    
    protected function generateCheckboxes($checkBoxes = array()) {
        $retStr = 
                '<div class="form-group">'. 
                '<div class="col-sm-12" style="margin-top: 7%;">';
        
        foreach($checkBoxes as $checkBox){
            $name = $checkBox->getName();
            
            $widget = "<label class=\"col-sm-4\" for=\"".  $checkBox->renderId() ."\">".
                           $this[$name]. ' ' . ucfirst($name) .' '. $this->widgetSchema->getFormFormatter()->getHelpFormat() .
                       "</label>";    
            
            $widget = $this->fillHelpId($checkBox, $widget);
            
            $retStr .= strtr($widget, array(
                '%help%' => $this->widgetSchema->getHelp($name),
            ));
            
        }
        
        
        $retStr .= 
                "</div>" .
                "</div>";
        
        return $retStr;
    }
    
    protected function renderFields($fields, &$checkBoxes = array()) {
        $output = '';
        
        foreach($this as $k => $field){
            if($field instanceof sfFormFieldSchema || $field->isHidden()){
                continue;
            }
            
            $widget = $field->getWidget();
            if($widget instanceof sfWidgetFormInputCheckbox){
                $checkBoxes[] = $field;
                continue;
            }
            
            $widgetName = $this->widgetSchema->generateName($k);
                         
            if(in_array($widgetName, $fields)) 
                $output .= $this->fillHelpId($field, $field->renderRow());
        }

        return $output;
    }
    
    
    public function renderRequiredFields(){
        $fields = $this->getRequiredFields();
        $requiredFields = $fields['required'];
        
        return $this->renderFields($requiredFields);
    }
    
    
    
    public function renderNonRequiredFields(){
        $checkBoxes = array();
        $fields = $this->getRequiredFields();
        $nonRequiredFields = $fields['non_required'];
        
        $output = $this->renderFields($nonRequiredFields, $checkBoxes);
        
        // genero los widget de checkbox de otra manera
        $output .= $this->generateCheckboxes($checkBoxes); 
        
        return $output;
    }
    
//    public function getJavaScripts() {
//        return array_merge(parent::getJavaScripts(), array('/js/evento_form.js'));
//    }

    public function renderJavascript() {

        $js = '<script type="text/javascript">';        
        $js .= '$(function() {' . "\n";
        
        foreach ($this as $field) {
            if(!$field->isHidden())
                $js .= "\t\t". '$("#' . $this->helpPrefix . $field->renderId() . '").tooltip();' . "\n";
        }
        
        $js .= '}); ' . "\n";
        
        $js .= '</script>';

        return $js;
    }

}
