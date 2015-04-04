<?php

/**
 * Evento filter form base class.
 *
 * @package    theeventmachine
 * @subpackage filter
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEventoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'descripcion'  => new sfWidgetFormFilterInput(),
      'fecha_inicio' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_fin'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'repetir'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'agendas_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Agenda')),
    ));

    $this->setValidators(array(
      'descripcion'  => new sfValidatorPass(array('required' => false)),
      'fecha_inicio' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'fecha_fin'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'repetir'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'agendas_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Agenda', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('evento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addAgendasListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('AgendaEvento.agenda_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Evento';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'descripcion'  => 'Text',
      'fecha_inicio' => 'Date',
      'fecha_fin'    => 'Date',
      'repetir'      => 'Boolean',
      'agendas_list' => 'ManyKey',
    );
  }
}
