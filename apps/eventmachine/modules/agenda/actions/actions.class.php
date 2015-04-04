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
  }
  
  public function executeGetFormularioEventoAjax($request) {
      if ($request->isXmlHttpRequest()) {
        return $this->renderPartial('event_form', array('form' => new EventoForm() ));
      }
  }
  
  public function executeProcesarFormularioEventoAjax($request) {
        $this->redirect404Unless($request->isXmlHttpRequest());
      
        $this->form = new EventoForm();

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter('evento'));
            if ($this->form->isValid()) {
                $event = $this->form->save();

                return $this->redirect('@agenda');
            }
        }
    }

}
