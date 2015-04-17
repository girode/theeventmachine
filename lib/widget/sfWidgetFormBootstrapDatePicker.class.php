<?php

/**
 * sfWidgetFormBootstrapDatePicker description.
 *
 * @package    eventmachine
 * @subpackage widget
 * @author     Gabriel Rode <gabriel_rode@hotmail.com>
 */
class sfWidgetFormBootstrapDatePicker extends sfWidgetForm
{
    
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
      
    if(array_key_exists('class', $attributes)){
        $attributes['class'] .= ' form-control';
    } else {
        $attributes['class'] = 'form-control';
    }
      
    $this->addOption('default_widget', new sfWidgetFormInputText(array(), $attributes));
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $widgetId = 'datetimepicker_' . $this->generateId($name);  
      
    return  "<div class='input-group date' id='". $widgetId ."'>".
                $this->getOption('default_widget')->render($name, $value).
                "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>".
            "</div>".
            $this->renderJS($widgetId); 
            
  }
  
  private function renderJS($widgetId) {
      return <<<EOD
<script type="text/javascript">
    $(function () {
        $('#$widgetId').datetimepicker();
    });
</script>      
EOD;
  }
  
  public function getStylesheets()
  {
    return array(
      '/css/bootstrap-datetimepicker.min.css' => 'all'
    );
  }
 
  public function getJavaScripts()
  {
    return array('/js/bootstrap-datetimepicker.min.js');
  }
  
  

}
