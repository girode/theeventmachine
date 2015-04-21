<?php

class sfWidgetFormSchemaFormatterBootstrapRequiredInTwoCols extends sfWidgetFormSchemaFormatterTwitterBootstrap
{
    protected $requiredLabelClass = 'required';
    protected $labelRowSize = 5, $fieldRowSize = 7;

    private function addRequiredClass($name, &$attributes = array()){
        // loop up to find the "required_fields" option
        $widget = $this->widgetSchema;
        
        do {
            $requiredFields = (array) $widget->getOption('required_fields');
        } while ($widget = $widget->getParent());

        // add a class (non-destructively) if the field is required
        $widgetName = $this->widgetSchema->generateName($name);
        
        if (in_array($widgetName, $requiredFields['required'])) {
            $attributes['class'] = isset($attributes['class']) ?
                    $attributes['class'] . ' ' . $this->requiredLabelClass :
                    $this->requiredLabelClass;
        }
    }
    
    public function generateLabel($name, $attributes = array()) {
        $this->addRequiredClass($name, $attributes);
        return parent::generateLabel($name, $attributes);
    }

    
}
