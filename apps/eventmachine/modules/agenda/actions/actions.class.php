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
        $this->usuario = $this->getUser()->getName();
        // $agenda_usuario_id = $this->getUser()->getAgenda()->getId();

        $this->form = new EventoForm(null, array(
            "usuario-simple" => true
        ));
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
                    ->andWhere('e.start >= ?', $start)
                    ->andWhere('e.start <= ?', $end);

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
                
                $response['status'] = 'ok';
            } else {
                foreach ($this->form->getErrorSchema() as $name => $error) {
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
