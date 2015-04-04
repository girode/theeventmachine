<?php

/**
 * Agenda filter form base class.
 *
 * @package    theeventmachine
 * @subpackage filter
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAgendaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'       => new sfWidgetFormFilterInput(),
      'eventos_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Evento')),
    ));

    $this->setValidators(array(
      'nombre'       => new sfValidatorPass(array('required' => false)),
      'eventos_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Evento', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agenda_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addEventosListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.AgendaEvento AgendaEvento')
      ->andWhereIn('AgendaEvento.evento_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Agenda';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'nombre'       => 'Text',
      'eventos_list' => 'ManyKey',
    );
  }
}
