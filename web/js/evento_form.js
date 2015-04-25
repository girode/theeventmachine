(function( $ ) {
 
    $.fn.addFieldStatus = function(options) {

        return this.each(function() {
            var id = $(this).attr('id').replace(/^help_/, '');
            var newDiv  = $("<div>")
                            .css({
                                display: 'inline-block',
                                width: '15px',
                                height: '15px',
                                background: '#FFF',
                                border: "thin solid #000",
                                "border-radius": "50%",
                                "vertical-align": "text-top",
                                "margin-left": "1%"
                            })
                            .attr('id', options['errorIds'][id]);
            
            $(this).after(newDiv);
        });

    };
 
}( jQuery ));

$(document).ready(function (){
    
    $("form#formAltaEvento").submit(function (event) {
        
        event.preventDefault();
        var $form = $(this);

         $.post($form.attr('action'), $form.serialize(), function (data) {
             var length = data.errors.length;

             // hay errores
             if (length) {
                 for (var i = 0, error_id; i < length; i++) {
                    error_id =  data.errors[i]['error_id'],
                    $("#"+ error_id).css('background', 'red');
                 }
             } else {
                 $("div#ticker.list-group > div.list-group").prepend(data.newHTML);
                 $("#calendar").fullCalendar('renderEvent', data.evento);
                 $('#eventFormModal').modal('hide');
             }
         }, 'json');

    }); 

});