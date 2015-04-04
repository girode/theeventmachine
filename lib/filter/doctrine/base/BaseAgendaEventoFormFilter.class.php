<?php

/**
 * AgendaEvento filter form base class.
 *
 * @package    theeventmachine
 * @subpackage filter
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAgendaEventoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('agenda_evento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgendaEvento';
  }

  public function getFields()
  {
    return array(
      'agenda_id' => 'Number',
      'evento_id' => 'Number',
    );
  }
}
