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
        
//        $evento = new Evento();
//        $evento->setInicio(date("d/m/Y H:i"));
        
        $this->form = new EventoForm(null, array(
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

    
    // Recupera los eventos para mostrarlos en el calendario
    public function executeGetEventosAjax(sfWebRequest $request) {
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

            $json_eventos = $q->execute(array(), 'json_event_object');
            
            $this->getResponse()->setContentType('application/json');

            return $this->renderText($json_eventos);
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
                $response['evento']  = $evento->toFullCalendarArray();
                $response['newHTML'] = $this->getPartial('evento', array("evento" => $evento));
                
            } else {
                
                foreach ($this->form->getErrorSchema() as $name => $error) {
                    // Skip global errors as they are appended as numeric keys 
                    // on the error schema
                    if(is_numeric($name)) continue;
                    
                    $id = $this->form[$name]->renderId();

                    $response['errors'][$id] = array(
                        'error_id'   => $this->form->getWidgetSchema()->getFormFormatter()->generateErrorId($id),
                        'message' => $error->getMessage(),
                    );
                    
                }
                
                
                if($this->form->hasGlobalErrors()){
                    
                    $response['errors']['global'] = array();

                    // La magia: 
                    // http://rajeshmeniya.blogspot.com.ar/2012/11/get-all-error-messages-from-symfony-14.html
                    foreach ($this->form->getGlobalErrors() as $error) {
                        $response['errors']['global'][] = $error->getMessage();
                    }  
                    
                }
                
//                $response['errors']['global'][] = 'error de testing';
                
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
    
    public function executeBorrarEventoAjax(sfWebRequest $request) {
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
    
    public function executeGetNextEventPageAjax(sfWebRequest $request){
        $left_off_id = $request->getParameter("id");
        $fecha = $request->getParameter("fecha");
        
        $agenda_usuario_id = $this->getUser()->getAgenda()->getId();
        $response = array();
        
        $q = Doctrine::getTable('Evento')
                    ->createQuery('e')
                    ->innerJoin('e.Agendas a')
                    ->where('a.id = ?', $agenda_usuario_id)
                    ->andWhere('e.inicio < ?', $fecha)
                    ->orderBy("e.inicio DESC")
                    ->limit(10);
        
        $html = "";
        $results = $q->execute();
        
        foreach($results as $result){
            $html .= $this->getPartial("evento", array('evento' => $result));
        }
        
        $response['c'] = $results->count();
        $response['links'] = $html;
        
        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode($response));
    }

}
