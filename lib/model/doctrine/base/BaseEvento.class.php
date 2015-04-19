<?php

/**
 * BaseEvento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $titulo
 * @property boolean $diario
 * @property string $descripcion
 * @property timestamp $inicio
 * @property timestamp $fin
 * @property boolean $repetir
 * @property string $url
 * @property boolean $editable
 * @property Doctrine_Collection $Agendas
 * @property Doctrine_Collection $AgendaEvento
 * 
 * @method integer             getId()           Returns the current record's "id" value
 * @method string              getTitulo()       Returns the current record's "titulo" value
 * @method boolean             getDiario()       Returns the current record's "diario" value
 * @method string              getDescripcion()  Returns the current record's "descripcion" value
 * @method timestamp           getInicio()       Returns the current record's "inicio" value
 * @method timestamp           getFin()          Returns the current record's "fin" value
 * @method boolean             getRepetir()      Returns the current record's "repetir" value
 * @method string              getUrl()          Returns the current record's "url" value
 * @method boolean             getEditable()     Returns the current record's "editable" value
 * @method Doctrine_Collection getAgendas()      Returns the current record's "Agendas" collection
 * @method Doctrine_Collection getAgendaEvento() Returns the current record's "AgendaEvento" collection
 * @method Evento              setId()           Sets the current record's "id" value
 * @method Evento              setTitulo()       Sets the current record's "titulo" value
 * @method Evento              setDiario()       Sets the current record's "diario" value
 * @method Evento              setDescripcion()  Sets the current record's "descripcion" value
 * @method Evento              setInicio()       Sets the current record's "inicio" value
 * @method Evento              setFin()          Sets the current record's "fin" value
 * @method Evento              setRepetir()      Sets the current record's "repetir" value
 * @method Evento              setUrl()          Sets the current record's "url" value
 * @method Evento              setEditable()     Sets the current record's "editable" value
 * @method Evento              setAgendas()      Sets the current record's "Agendas" collection
 * @method Evento              setAgendaEvento() Sets the current record's "AgendaEvento" collection
 * 
 * @package    theeventmachine
 * @subpackage model
 * @author     grode
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEvento extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('evento');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'autoincrement' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('titulo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'The text on an event\'s element',
             'length' => 255,
             ));
        $this->hasColumn('diario', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             'comment' => 'Whether an event occurs at a specific time-of-day. This property affects whether an event\'s time is shown',
             ));
        $this->hasColumn('descripcion', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('inicio', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             'comment' => 'The date/time an event begins',
             ));
        $this->hasColumn('fin', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => false,
             'comment' => 'The exclusive date/time an event ends. It is the moment immediately after the event has ended. For example, if the last full day of an event is Thursday, the exclusive end of the event will be 00:00:00 on Friday!',
             ));
        $this->hasColumn('repetir', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             ));
        $this->hasColumn('url', 'string', 2000, array(
             'type' => 'string',
             'notnull' => false,
             'comment' => 'A URL that will be visited when this event is clicked by the user. For more information on controlling this behavior, see the eventClick callback.',
             'length' => 2000,
             ));
        $this->hasColumn('editable', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             'comment' => 'Overrides the master editable option for this single event.',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Agenda as Agendas', array(
             'refClass' => 'AgendaEvento',
             'local' => 'evento_id',
             'foreign' => 'agenda_id'));

        $this->hasMany('AgendaEvento', array(
             'local' => 'id',
             'foreign' => 'evento_id'));
    }
}