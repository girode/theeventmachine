<?php
/**
 * Class sfWidgetFormSchemaFormatterTwitterBootstrap
 */
class sfWidgetFormSchemaFormatterTwitterBootstrap extends sfWidgetFormSchemaFormatter
{
    protected
        $rowFormat = "<div class=\"form-group %row_class%\">\n %label%\n <div class=\"col-sm-5\">%field%</div>\n  %error%\n  %help%\n  %hidden_fields%\n </div>\n",
        $errorRowFormat = '%errors%',
        $errorListFormatInARow = "<p class=\"help-block\">%errors%</p>\n",
        $errorRowFormatInARow = "%error% ",
        $namedErrorRowFormatInARow = "%name%: %error% ",
        $helpFormat = '<p class="help-block">%help%</p>',
        $decoratorFormat = "%content%";

    public function __construct(sfWidgetFormSchema $widgetSchema)
    {
        foreach ($widgetSchema->getFields() as $field) {
            if (get_class($field) == 'sfWidgetFormInputText') {
                $classAttr = $field->getAttribute('class');
                $field->setAttribute('class', ($classAttr == '')? 'form-control' : 'form-control '. $classAttr);
            }
        }
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
            $attributes['class'] .= ' control-label col-sm-2';
        } else {
            $attributes['class'] = 'control-label col-sm-2';
        }
        return parent::generateLabel($name, $attributes);
    }
}