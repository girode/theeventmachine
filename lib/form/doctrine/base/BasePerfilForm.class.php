<?php

/**
 * Perfil form base class.
 *
 * @method Perfil getObject() Returns the current form's model object
 *
 * @package    theeventmachine
 * @subpackage form
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePerfilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'fecha_nacimiento' => new sfWidgetFormDate(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fecha_nacimiento' => new sfValidatorDate(array('required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('perfil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Perfil';
  }

}
