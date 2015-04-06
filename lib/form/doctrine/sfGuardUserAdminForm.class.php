<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm {

    public function configure() {
        parent::configure();

        $perfilForm = new PerfilForm($this->object->Perfil);
        unset($perfilForm['id'], $perfilForm['sf_guard_user_id']);
        $this->embedForm('Perfil', $perfilForm);
        
    }
}
