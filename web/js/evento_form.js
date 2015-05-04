$(document).ready(function (){

    $("form#formAltaEvento").trackValidationStatus({
        excludedItems: '#evento__csrf_token, input[type=checkbox], input[type=submit]',
        
        'onSuccess': function(data){
            $("div#ticker > div#eventList").prepend(data.newHTML);
            $("#calendar").fullCalendar('renderEvent', data.evento);
            $('#eventFormModal').modal('hide');
        },
    
        cancelSelector: 'div#eventFormModal.modal',
        
    });
    

});