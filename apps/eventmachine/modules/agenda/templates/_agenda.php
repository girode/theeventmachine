<div class="row">
    <div class="col-md-9" id="calendar"></div>
    <div class="col-md-3 list-group" id="ticker">
        <div id="eventList">
            <?php foreach($eventos as $evento): ?>
                <?php include_partial("evento", array("evento" => $evento)); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // initialize the calendar...

        $("#calendar").fullCalendar({
            events: {
                url: '<?php echo url_for('@get_eventos_ajax')?>',
                eventDataTransform: function( eventData ) {
                    return {
                        title: eventData.titulo,
                        start: eventData.inicio,
                        end: eventData.fin,
                        id: eventData.id
                    };
                }        
            }
        });
        
        /* Manejo el boton de creacion de eventos */
        
        var createButton = $(
        "<div id=\"new-event-form-div\" data-toggle=\"tooltip\"\">" + 
            "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#eventFormModal\">+" +
        "</button></div>");
        
        createButton.tooltip({
            title: "Crear Evento"
        });
        
        $("div.fc-toolbar > div.fc-right").append(createButton);

        /* Manejo el boton cerrar de cada evento */
        
        $( "div#eventList" ).on("click", "button", function( event ) {
            event.preventDefault();
            var boton = $(this);
            var evtId = boton.siblings("input").val();
            
            // Lanzo ajax req para eliminar el evento. Si me da ok, entonces 
            // elimino el elemento padre, sino lanzo error
            $.ajax("<?php echo url_for("@borrar_evento_ajax")?>",{
                method: "POST",
                data: { id : evtId },
                dataType: "json",
                success: function(response){
                    if(response.errors){
                        $("div.error-modal")
                            .on('show.bs.modal', function (event) {
                                var modal = $(this);
                                modal.find('.modal-title').text("Disculpe, hubo un error :(");
                                modal.find('.modal-body').text(response.errors.msg);
                            })
                            .modal();
                    } else {
                        // Saco elemento padre (y a mi mismo) del DOM
                        boton.parent().remove();
                        
                        // Elimino evento del calendario
                        // TODO: Recuperar el identificador (no es el id) del 
                        // evento y eliminarlo usando .fullCalendar( 'removeEvents' [, idOrFilter ] )
                        
                        // $("#calendar").fullCalendar( 'refetchEvents' );
                        $("#calendar").fullCalendar( 'removeEvents' , evtId);
                        
                    }
                }
            });
            
        });

        
        //TODO: Implementar un scroller y la paginacion correspondiente
        
//        $('.some_element').bind('scroll', function(){
//            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
//               var new_div = '<div class="new_block"></div>';
//               $('.main_content').append(new_div.load('/path/to/script.php'));
//            }
//         });
        
        

    });
</script>