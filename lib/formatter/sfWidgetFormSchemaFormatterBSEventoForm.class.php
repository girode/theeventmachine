<?php
/**
 * Class     sfWidgetFormSchemaFormatterBSEventoForm
 */
class sfWidgetFormSchemaFormatterBSEventoForm extends sfWidgetFormSchemaFormatter
{
    
    protected $formControlWidgets = array('sfWidgetFormInputText', 'sfWidgetFormInputPassword', 'sfWidgetFormTextarea');
    protected $requiredLabelClass = 'required';
    protected $helpPrefix = 'help_';
    protected $helpId     = '';
    protected $errorPrefix = 'error_';
    protected $errorId     = '';
    
    protected
//        $errorListFormatInARow = "<p class=\"help-block\">%errors%</p>\n",
        $errorRowFormatInARow = "%error% ",
        $namedErrorRowFormatInARow = "%name%: %error% ",
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
    
    public function setErrorId($newErrorId){
        return $this->errorId = $newErrorId;
    }
    
    public function generateErrorId($id){
//        return $this->setErrorId($this->errorPrefix . $id);
        return $this->errorPrefix . $id;
    }
    
    public function getHelpId(){
        return $this->helpId;
    }
    
    public function setHelpId($newHelpId){
        return $this->helpId = $newHelpId;
    }
    
    public function generateHelpId($id){
        return $this->setHelpId($this->helpPrefix . $id);
    }
    
    public function getHelpFormat() {
        return '<span'.
                 ' class="glyphicon glyphicon-question-sign"'.
                 ' aria-hidden="true"'.
                 ' data-toggle="tooltip"'.
                 ' data-placement="top"'.
                 ' id="%help_field_id%"'.
                 ' title="%mandatory_field% %help%">'.
                '</span>';
    }
    
    public function formatHelp($help) {
        return strtr(parent::formatHelp($help), array('%help_field_id%' => $this->getHelpId()));        
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
        
        parent::__construct($widgetSchema);
    }
    

    private function findId($field) {
        $matches = array();
        $pattern = '/id="(\w+)"/';
        preg_match($pattern, $field, $matches);
        
        return $matches[1];
    }
    
    public function findName($field) {
        $matches = array();
        $pattern = '/name="(\w+\[\w+\])"/';
        preg_match($pattern, $field, $matches);
        
        return $matches[1];
    }
    
    
    public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
    {
        // Usado por parent::formatRow y formatHelp 
        $this->generateHelpId($this->findId($field));
        
        $row = parent::formatRow(
            $label,
            $field,
            $errors,
            $help,
            $hiddenFields
        );
        
        return strtr($row, array(
            '%row_class%' => count($errors) ? ' has-error' : '',
            '%mandatory_field%' => $this->isMandatoryField($this->findName($field))? '' : '(opcional)'
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
    
    public function isMandatoryField($fieldName){
        $fields     = $this->widgetSchema->getOption('required_fields');
        return in_array($fieldName, $fields['required']);
    }
    
    
    
}