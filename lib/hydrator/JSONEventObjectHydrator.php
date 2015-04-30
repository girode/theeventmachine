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
            // $datum['e__repetir'] me va a permitir definir si el evento es 
            // recurrente o no
            // El problema es buscar la manera de definir la recurrencia del evento
            // 
            // Para ello, el requisito es:
            /*
            It is possible to define daily or weekly recurring events. 
            Use Duration-ish times in the Event Object's start and end properties, or use the dow property.
            See businessHours for more information.
             * 
             * Ej: dow: [ 1, 2, 3, 4 ]
             * 
             * pero necesito extender mi modelo actual
            */
            
            $ar = array(
                'id'         => $datum['e__id'],
                'title'      => $datum['e__titulo'], 
                'allDay'     => $datum['e__diario'],
                'start'      => date('Y-m-d\TH:i:s', strtotime($datum['e__inicio'])),
                'end'        => date('Y-m-d\TH:i:s', strtotime($datum['e__fin'])),
                'url'        => $datum['e__url'],
                'editable'   => $datum['e__editable'],
            );
            
//            if($ar['id'] == 1)
//                $ar['dow'] = array(2,5);
                
            $retArray[] = $ar;    
                
        }
      
        
        return json_encode($retArray);
    }
    
}
