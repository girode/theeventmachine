<?php

/**
 * Agenda form base class.
 *
 * @method Agenda getObject() Returns the current form's model object
 *
 * @package    theeventmachine
 * @subpackage form
 * @author     grode
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAgendaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'nombre'       => new sfWidgetFormInputText(),
      'eventos_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Evento')),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'eventos_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Evento', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agenda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agenda';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['eventos_list']))
    {
      $this->setDefault('eventos_list', $this->object->Eventos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveEventosList($con);

    parent::doSave($con);
  }

  public function saveEventosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['eventos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Eventos->getPrimaryKeys();
    $values = $this->getValue('eventos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Eventos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Eventos', array_values($link));
    }
  }

}
