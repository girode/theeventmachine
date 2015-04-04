<?php

/**
 * AgendaEvento form base class.
 *
 * @method AgendaEvento getObject() Returns the current form's model object
 *
 * @package    theeventmachine
 * @subpackage form
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAgendaEventoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'agenda_id' => new sfWidgetFormInputHidden(),
      'evento_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'agenda_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('agenda_id')), 'empty_value' => $this->getObject()->get('agenda_id'), 'required' => false)),
      'evento_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('evento_id')), 'empty_value' => $this->getObject()->get('evento_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agenda_evento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AgendaEvento';
  }

}
