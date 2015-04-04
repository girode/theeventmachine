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
//      $this->eventos = Metodo para obtener eventos mas recientes
  }
  
//  public function executeGetFormularioEventoAjax($request) {
//      if ($request->isXmlHttpRequest()) {
//        return $this->renderPartial('event_form', array('form' => new EventoForm() ));
//      }
//  }
  
    public function executeProcesarFormularioEventoAjax($request) {
        
        // Cargar nuevo evento solo para una agenda, la del usuario logueado 
        
        $this->form = new EventoForm();

        if ($request->isMethod(sfRequest::POST) && $request->isXmlHttpRequest()) {

            $this->form->bind($request->getParameter('evento'));
            if ($this->form->isValid()) {
                
                $evento = $this->form->save();
                $response['errors'] = array();
            }
        } else {
            foreach ($this->folderForm->getErrors() as $name => $error) {
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
