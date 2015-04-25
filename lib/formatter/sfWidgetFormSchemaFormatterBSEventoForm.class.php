<?php
/**
 * Class     sfWidgetFormSchemaFormatterBSEventoForm
 */
class sfWidgetFormSchemaFormatterBSEventoForm extends sfWidgetFormSchemaFormatter
{
    // protected $labelRowSize = 3, $fieldRowSize = 5, $helpRowSize = 4;
    protected $formControlWidgets = array('sfWidgetFormInputText', 'sfWidgetFormInputPassword', 'sfWidgetFormTextarea');
    protected $requiredLabelClass = 'required';
    
    protected
//        $errorListFormatInARow = "<p class=\"help-block\">%errors%</p>\n",
        $errorRowFormatInARow = "%error% ",
        $namedErrorRowFormatInARow = "%name%: %error% ",
//        $helpFormat = '<p class="help-block col-sm-">%help%</p>',
        $decoratorFormat = "%content%";
    

    public function getNormalRowFormat() {
        return "<div class=\"form-group %row_class%\">\n".
                    "<div class=\"col-sm-12\">".
                        "%label%\n".
                        "%field%".
                    "</div>\n".
                    "%help%\n".
                    "%hidden_fields%\n".
                "</div>\n";
    }
    
    public function getHelpFormat() {
        return '<span'.
                 ' class="glyphicon glyphicon-search"'.
                 ' aria-hidden="true"'.
                 ' data-toggle="tooltip"'.
                 ' data-placement="top"'.
                 ' id="%help_field_id%"'.
                 ' title="%help%">'.
                '</span>';
    }
    
    
    public function getSpecialRowFormat() {
        return "<div class=\"form-group %row_class%\">\n".
                    "<div class=\"col-sm-12\">".
                        "%label% %help%\n".
                        "%field%".
                    "</div>\n".
                    "%hidden_fields%\n".
                "</div>\n";
    }
    
    
    public function __construct(sfWidgetFormSchema $widgetSchema)
    {
        foreach ($widgetSchema->getFields() as $field) {
            if (in_array(get_class($field), $this->formControlWidgets) ) {
                $classAttr = $field->getAttribute('class');
                $field->setAttribute('class', ($classAttr == '')? 'form-control' : 'form-control '. $classAttr);
            }
        }
        
        $this->setRowFormat($this->getSpecialRowFormat());
        
        // $this->setErrorListFormatInARow("<p class=\"help-block col-sm-". $this->helpRowSize ."\">%errors%</p>\n");
        
        parent::__construct($widgetSchema);
    }
    

    public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
    {
        $row = parent::formatRow(
            $label,
            $field,
            $errors,
            $help,
            $hiddenFields
        );

        return strtr($row, array(
            '%row_class%' => count($errors) ? ' has-error' : '',
        ));
        
    }

    public function generateLabel($name, $attributes = array())
    {
        $this->addRequiredClass($name, $attributes);
        
        if (isset($attributes['class'])) {
            $attributes['class'] .= ' control-label';
        } else {
            $attributes['class'] = 'control-label';
        }
        return parent::generateLabel($name, $attributes);
    }
    
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
    
    
}