<?php
/**
 * Class sfWidgetFormSchemaFormatterTwitterBootstrap
 */
class sfWidgetFormSchemaFormatterTwitterBootstrap extends sfWidgetFormSchemaFormatter
{
    protected
        $rowFormat = "<div class=\"form-group %row_class%\">\n %label%\n %field%\n  %error%\n  %help%\n  %hidden_fields%\n </div>\n",
        $errorRowFormat = '%errors%',
        $errorListFormatInARow = "<p class=\"help-block\">%errors%</p>\n",
        $errorRowFormatInARow = "%error% ",
        $namedErrorRowFormatInARow = "%name%: %error% ",
        $helpFormat = '<p class="help-block">%help%</p>',
        $decoratorFormat = '%content%';

    public function __construct(sfWidgetFormSchema $widgetSchema)
    {
        foreach ($widgetSchema->getFields() as $field) {
            if (get_class($field) == 'sfWidgetFormInputText') {
                $field->setAttribute('class', 'form-control ' . $field->getAttribute('class'));
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
            $attributes['class'] .= ' control-label';
        } else {
            $attributes['class'] = 'control-label';
        }
        return parent::generateLabel($name, $attributes);
    }
}