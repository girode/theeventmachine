<?php

/**
 * Perfil filter form base class.
 *
 * @package    theeventmachine
 * @subpackage filter
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePerfilFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_nacimiento' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha_nacimiento' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('perfil_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Perfil';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'fecha_nacimiento' => 'Date',
      'sf_guard_user_id' => 'ForeignKey',
    );
  }
}
