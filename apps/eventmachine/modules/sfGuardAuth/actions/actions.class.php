<?php

/**
 * main actions.
 *
 * @package    theeventmachine
 * @subpackage main
 * @author     grode
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
require_once(sfConfig::get('sf_plugins_dir') . '/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class sfGuardAuthActions extends BasesfGuardAuthActions {

    public function executeIndex(sfWebRequest $request) {
        $user = $this->getUser();
        
        if ($user->isAuthenticated()) {
            return $this->redirect('@homepage');
        }

        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
        $this->form = new $class();
        
    }

}
