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
      'identificador' => new sfWidgetFormFilterInput(),
      'titulo'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'diario'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'descripcion'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inicio'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fin'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'repetir'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'url'           => new sfWidgetFormFilterInput(),
      'editable'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'agendas_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Agenda')),
    ));

    $this->setValidators(array(
      'identificador' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'titulo'        => new sfValidatorPass(array('required' => false)),
      'diario'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'descripcion'   => new sfValidatorPass(array('required' => false)),
      'inicio'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fin'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'repetir'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'url'           => new sfValidatorPass(array('required' => false)),
      'editable'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'agendas_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Agenda', 'required' => false)),
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
      'id'            => 'Number',
      'identificador' => 'Number',
      'titulo'        => 'Text',
      'diario'        => 'Boolean',
      'descripcion'   => 'Text',
      'inicio'        => 'Date',
      'fin'           => 'Date',
      'repetir'       => 'Boolean',
      'url'           => 'Text',
      'editable'      => 'Boolean',
      'agendas_list'  => 'ManyKey',
    );
  }
}
