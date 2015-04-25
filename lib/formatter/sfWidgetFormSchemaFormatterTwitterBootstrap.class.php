<?php
/**
 * Class sfWidgetFormSchemaFormatterTwitterBootstrap
 */
class sfWidgetFormSchemaFormatterTwitterBootstrap extends sfWidgetFormSchemaFormatter
{
    protected $labelRowSize = 3, $fieldRowSize = 5, $helpRowSize = 4;
    protected $formControlWidgets = array('sfWidgetFormInputText', 'sfWidgetFormInputPassword', 'sfWidgetFormTextarea');
    
    protected
//        $errorListFormatInARow = "<p class=\"help-block\">%errors%</p>\n",
        $errorRowFormatInARow = "%error% ",
        $namedErrorRowFormatInARow = "%name%: %error% ",
        $helpFormat = '<p class="help-block col-sm-">%help%</p>',
        $decoratorFormat = "%content%";
    

    public function __construct(sfWidgetFormSchema $widgetSchema)
    {
        foreach ($widgetSchema->getFields() as $field) {
            if (in_array(get_class($field), $this->formControlWidgets) ) {
                $classAttr = $field->getAttribute('class');
                $field->setAttribute('class', ($classAttr == '')? 'form-control' : 'form-control '. $classAttr);
            }
        }
        
        $this->setRowFormat("<div class=\"form-group %row_class%\">\n %label%\n <div class=\"col-sm-". $this->fieldRowSize ."\">%field%</div>\n  %error%\n  %help%\n  %hidden_fields%\n </div>\n");
        $this->setErrorListFormatInARow("<p class=\"help-block col-sm-". $this->helpRowSize ."\">%errors%</p>\n");
        
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
        if (isset($attributes['class'])) {
            $attributes['class'] .= ' control-label col-sm-' . $this->labelRowSize;
        } else {
            $attributes['class'] = 'control-label col-sm-' . $this->labelRowSize;
        }
        return parent::generateLabel($name, $attributes);
    }
}