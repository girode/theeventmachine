<?php

/**
 * agenda actions.
 *
 * @package    theeventmachine
 * @subpackage agenda
 * @author     grode
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class agendaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $this->usuario = $this->getUser()->getUsername();
      $this->form    = new EventoForm();
//      var_dump($this->getUser()->getAgenda()->getId()); die;
  }
  
  public function executeGetEventosAjax($request) {
      if ($request->isXmlHttpRequest()) {
        
        $start = $request->getParameter('start');  
        $end = $request->getParameter('end');  
        $agenda_id = $this->getUser()->getAgenda()->getId();
        
        $q = Doctrine::getTable('Evento')
                ->createQuery('e')
                ->innerJoin('e.Agendas a')
                ->where('a.id = ?', $agenda_id)
                ->andWhere('e.start >= ?', $start)
                ->andWhere('e.start <= ?', $end);
        
        $response = $q->fetchArray();
        
        $this->getResponse()->setContentType('application/json');

        return $this->renderText(json_encode($response));
      }
  }
  
    public function executeProcesarFormularioEventoAjax($request) {
        
        // Cargar nuevo evento solo para una agenda, la del usuario logueado 
        
        $this->form = new EventoForm();
        $response = array(
            'status' => 'error',
            'errors' => array()
        );
        
        
        if ($request->isMethod(sfRequest::POST) && $request->isXmlHttpRequest()) {

            $this->form->bind($request->getParameter('evento'));
            if ($this->form->isValid()) {
                
                $evento = $this->form->save();
                $response['status'] = 'ok';
                
            } else {
                foreach ($this->form->getErrors() as $name => $error) {
                    $response['errors'][] = array(
                        'field' => $name,
                        'message' => $error->getMessage(),
                    );
                }
            }
            
        } 

        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode($response));
    }

}
