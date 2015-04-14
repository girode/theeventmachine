<?php

/**
 * agenda actions.
 *
 * @package    theeventmachine
 * @subpackage agenda
 * @author     grode
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class agendaActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
        // TODO: Probar y configurar cultura
//        $this->getUser()->setCulture("en_US");
        $this->usuario = $this->getUser()->getName();
        
        $evento = new Evento();
        $evento->setInicio(date("Y-m-d"));
        
        $this->form = new EventoForm($evento, array(
            "usuario-simple" => true
        ));
        
        $this->eventos = Doctrine::getTable('Evento')
                ->findByAgendaId($this->getUser()->getAgenda()->getId()); 
        
//        $agendaGeneral = Doctrine::getTable('Agenda')
//                    ->findOneByNombre("Agenda General");
//
//        $agenda_general_id = $agendaGeneral->getId();
//        $agenda_usuario_id = $this->getUser()->getAgenda()->getId();
//        
//        $this->eventos = Doctrine::getTable('Evento')->createQuery('e')
//                    ->innerJoin('e.Agendas a')
//                    ->whereIn('a.id', array($agenda_usuario_id, $agenda_general_id))
//                    ->orderBy("e.inicio DESC")
//                    ->execute();
        
                
    }

    public function executeGetEventosAjax($request) {
        if ($request->isXmlHttpRequest()) {

            $start = $request->getParameter('start');
            $end = $request->getParameter('end');
            $agenda_usuario_id = $this->getUser()->getAgenda()->getId();

            $agendaGeneral = Doctrine::getTable('Agenda')
                    ->findOneByNombre("Agenda General");

            $agenda_general_id = $agendaGeneral->getId();

            $q = Doctrine::getTable('Evento')
                    ->createQuery('e')
                    ->innerJoin('e.Agendas a')
                    ->whereIn('a.id', array($agenda_usuario_id, $agenda_general_id))
                    ->andWhere('e.inicio >= ?', $start)
                    ->andWhere('e.inicio <= ?', $end);

            $response = $q->fetchArray();

            $this->getResponse()->setContentType('application/json');

            return $this->renderText(json_encode($response));
        }
    }

    public function executeProcesarFormularioEventoAjax($request) {

        $this->form = new EventoForm(null, array(
            "usuario-simple" => true
        ));
        
               
        $response = array(
            'status' => 'error',
            'errors' => array()
        );


        if ($request->isMethod(sfRequest::POST) && $request->isXmlHttpRequest()) {

            $this->form->bind($request->getParameter('evento'));
            
            if ($this->form->isValid()) {

                $evento = $this->form->save();
                
                // Cargar nuevo evento solo para una agenda, la del usuario logueado
                $perfil_id = $this->getUser()->getPerfil()->getId();
                
                $a = Doctrine::getTable("Agenda")->findOneByPerfilId($perfil_id);
                
                $evento->Agendas->add($a);
                $evento->save();
                
                $response['status']  = 'ok';
                $response['evento']  = $evento->toArray();
                $response['newHTML'] = $this->getPartial('evento', array("evento" => $evento));
                
            } else {
                
                foreach ($this->form->getErrorSchema() as $name => $error) {
                    $response['errors'][] = array(
                        'field' => $name,
                        'message' => $error->getMessage(),
                    );
                }
                
            }
            
            $this->getResponse()->setContentType('application/json');
            return $this->renderText(json_encode($response));
        }

        
    }
    
    
    /*
     * Borra el evento según su id. Se fija que el evento pertenezca al usuario
     * logueado.
     * Nota: Esta funcion no soporta el borrado multiple, y si el evento 
     * pertenece a distintas agendas
     * 
     * TODO: Contemplar si el evento pertenece a distintas agendas
     *
     */
    
    public function executeBorrarEventoAjax($request) {
        if ($request->isXmlHttpRequest()) {
            if($request->isMethod(sfRequest::POST)) {
                
                $response = array();
                $agenda_id = $this->getUser()->getAgenda()->getId();
                $evento_id = $request->getParameter("id");
                
                // buscar evento por id 
                // intentar borrado
                $q = Doctrine_Query::create()
                        ->delete('AgendaEvento')
                        ->addWhere('evento_id = ?', $evento_id)
                        ->whereIn('agenda_id', array($agenda_id));

                
//                $response["query"] = $q->getSqlQuery();
//                $response["param"] = $q->getParams();
                
                $deleted = $q->execute();
                
                if($deleted !== 1) {
                    $response['errors'] = array();
                    $response['errors']['msg'] = "Hubo un error al borrar el evento. Por favor, intente de nuevo en unos segundos";
                } else {
                    $evento = Doctrine::getTable("Evento")->findOneById($evento_id);
                    $evento->delete();
                }
                
                $this->getResponse()->setContentType('application/json');
                return $this->renderText(json_encode($response));
            }
        }
    }

}
