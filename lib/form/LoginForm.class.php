<?php

/**
 * LoginForm for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class LoginForm extends sfGuardFormSignin {

    public function configure() {
        $this->getWidgetSchema()->getFormFormatter()->setRowFormat(
            "%error%%field%%help%%hidden_fields%\n"
        );
        
        $this->widgetSchema['username']->setAttribute("placeholder" ,"Username or E-Mail");
        $this->widgetSchema['password']->setAttribute("placeholder" ,"Password");
                
    }

}
