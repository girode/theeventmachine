<?php

//

/**
 * Allows minification of Login Form
 *
 * @author grode
 */
class sfWidgetFormSchemaFormatterMiniSignIn extends sfWidgetFormSchemaFormatter {

    private $formControlWidgets = array('sfWidgetFormInputText', 'sfWidgetFormInputPassword');
    
    protected
        $rowFormat = "%error%%label%%field%%help%%hidden_fields%\n",
        $decoratorFormat = "<div class=\"form-group %row_error_class%\">\n  %content%</div>";


    public function __construct(sfWidgetFormSchema $widgetSchema) {
        foreach ($widgetSchema->getFields() as $field) {
            if (in_array(get_class($field), $this->formControlWidgets) ) {
                $field->setAttribute('class', 'form-control ' . $field->getAttribute('class'));
            }
        }
        parent::__construct($widgetSchema);
    }

    public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null) {
        $row = parent::formatRow($label, $field, $errors, $help, $hiddenFields);

        return strtr($row, array(
            '%row_error_class%' => count($errors) ? ' has-error' : '',
        ));
    }

    public function generateLabel($name, $attributes = array()) {
        if (isset($attributes['class'])) {
            $attributes['class'] .= ' control-label sr-only';
        } else {
            $attributes['class'] = 'control-label sr-only';
        }
        return parent::generateLabel($name, $attributes);
    }

}
