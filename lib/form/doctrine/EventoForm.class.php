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
        
        $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'checkFechas')))
        );
        
    }
    
    public function checkFechas($validator, $values) {
        
        if(!empty($values['inicio']) && !empty($values['fin'])){
            $start_time = new DateTime($values['inicio']); 
            $end_time   = new DateTime($values['fin']);
            
            if ($start_time >= $end_time) {
                throw new sfValidatorError($validator, 'La fecha de inicio '
                        . 'del evento debe ser anterior a la fecha de fin');
 
            }
        }
        
        return $values;
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
    
    protected function renderCheckBox(sfFormField $checkBox, sfWidgetFormSchemaFormatter $formFormatter = null){
        $name = $checkBox->getName();
        
        if(null === $formFormatter)
            $formFormatter = $this->getWidgetSchema()->getFormFormatter();
        
        $helpDescription = $formFormatter->getWidgetSchema()->getHelp($name);
        
        $formFormatter->generateHelpId($checkBox->renderId());
        
        $formattedName = $formFormatter->findName($checkBox);
        
        $help = strtr($formFormatter->formatHelp($helpDescription), array(
            '%mandatory_field%' => $formFormatter->isMandatoryField($formattedName)? '' : '(opcional)'
        ));
        
        return  "<label class=\"col-sm-4\" for=\"".  $checkBox->renderId() ."\">".   
                    $checkBox. ' ' . ucfirst($name) .' '. $help .
                "</label>";
    }
    
    protected function generateCheckboxes($checkBoxes = array()) {
        $formFormatter = $this->widgetSchema->getFormFormatter();
        
        $retStr = '<div class="form-group">'. "\n". 
                  '<div class="col-sm-12" style="margin-top: 7%;">' . "\n";
        
        foreach($checkBoxes as $checkBox){
            $retStr .= $this->renderCheckBox($checkBox, $formFormatter) . "\n";
        }
        
        $retStr .= "</div>" . "\n" .
                   "</div>";
        
        return $retStr;
    }

    
    protected function renderFields($fields, &$checkBoxes = array()) {
        $output = '';
        
        foreach($this as $k => $field){
            if($field instanceof sfFormFieldSchema || $field->isHidden()){
                continue;
            }
            
            if($field->getWidget() instanceof sfWidgetFormInputCheckbox){
                $checkBoxes[] = $field;
                continue;
            }
            
            $widgetName = $this->widgetSchema->generateName($k);
                         
            if(in_array($widgetName, $fields)){
                $output .= $field->renderRow();
            } 
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
    
    public function getJavaScripts() {
        return array_merge(parent::getJavaScripts(), array('/js/evento_form.js'));
    }

    public function renderJavascript() {
        $ff = $this->widgetSchema->getFormFormatter();
//        $errorIds = array();
        
        $js = '<script type="text/javascript">';        
        $js .= '$(function() {' . "\n";
        
        foreach ($this as $field) {
            if(!$field->isHidden()){
                $id = $field->renderId();
                
                $js .= "\t\t". '$("#' . $ff->generateHelpId($id) . '").tooltip();' . "\n";
//                $errorIds[$id] = $ff->generateErrorId($id);
            }
        }
        
        $js .= "});\n";
        
        $js .= '</script>';

        return $js;
    }

}
