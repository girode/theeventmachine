<?php

/**
 * Devuelve un array JSON, cuyos elementos son objetos evento soportados 
 * por full calendar, es decir, poseen el nombre de los campos en ingles y
 * las fechas estan en formato 8601
 * 
 * Referencias:
 * - http://en.wikipedia.org/wiki/ISO_8601
 * - http://fullcalendar.io/docs/event_data/Event_Object/
 * 
 *
 * @author grode
 */

class JSONEventObjectHydrator extends Doctrine_Hydrator_Abstract {
    
    public function hydrateResultSet($stmt) {
        $retArray = array();
        $data = $stmt->fetchAll(Doctrine_Core::FETCH_ASSOC);
        
        foreach($data as $datum){
            $retArray[] = array(
                'id'     => $datum['e__id'],
                'title'  => $datum['e__titulo'], 
                'allDay' => $datum['e__diario'],
                'start'  => date('Y-m-d\TH:i:s', strtotime($datum['e__inicio'])),
                'end'    => date('Y-m-d\TH:i:s', strtotime($datum['e__fin']))
            );
        }
        
        return json_encode($retArray);
    }
    
}
