<?php

/**
 * Evento form base class.
 *
 * @method Evento getObject() Returns the current form's model object
 *
 * @package    theeventmachine
 * @subpackage form
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEventoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'identificador' => new sfWidgetFormInputText(),
      'title'         => new sfWidgetFormInputText(),
      'allDay'        => new sfWidgetFormInputCheckbox(),
      'descripcion'   => new sfWidgetFormInputText(),
      'start'         => new sfWidgetFormDate(),
      'end'           => new sfWidgetFormDate(),
      'repetir'       => new sfWidgetFormInputCheckbox(),
      'url'           => new sfWidgetFormTextarea(),
      'editable'      => new sfWidgetFormInputCheckbox(),
      'agendas_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Agenda')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'identificador' => new sfValidatorInteger(array('required' => false)),
      'title'         => new sfValidatorString(array('max_length' => 255)),
      'allDay'        => new sfValidatorBoolean(array('required' => false)),
      'descripcion'   => new sfValidatorString(array('max_length' => 255)),
      'start'         => new sfValidatorDate(),
      'end'           => new sfValidatorDate(array('required' => false)),
      'repetir'       => new sfValidatorBoolean(array('required' => false)),
      'url'           => new sfValidatorString(array('max_length' => 2000, 'required' => false)),
      'editable'      => new sfValidatorBoolean(array('required' => false)),
      'agendas_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Agenda', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('evento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Evento';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['agendas_list']))
    {
      $this->setDefault('agendas_list', $this->object->Agendas->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveAgendasList($con);

    parent::doSave($con);
  }

  public function saveAgendasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['agendas_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Agendas->getPrimaryKeys();
    $values = $this->getValue('agendas_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Agendas', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Agendas', array_values($link));
    }
  }

}
