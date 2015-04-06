<?php

class myUser extends sfGuardSecurityUser {

    /**
     * Returns the user Perfil
     *
     * @return Perfil
     */
    
    public function getPerfil() {
        return $this->getGuardUser()->getPerfil();
    }
    
    /**
     * Returns the user Agenda
     *
     * @return Agenda
     */
    
    public function getAgenda() {
        return $this->getPerfil()->getAgenda();
    }
    
    

}
