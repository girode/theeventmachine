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
                        end: eventData.fin
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
        $("div#eventList > a.list-group-item > button.removeEventButton").click( function() {
            alert("Voy a cerrar el evento!");
        });

        
        // initialize the event scroller
//        $("#eventTicker").jscroll();

//        $('#eventFormModal').on('show.bs.modal', function (event) {
//            
//            // var button = $(event.relatedTarget) // Button that triggered the modal
//            // var recipient = button.data('whatever') // Extract info from data-* attributes
//            var modal = $(this);
//            
//            // Si esta vacio
//            if( !( $.trim( modal.find('.modal-body').html() ).length ) ) { 
//                modal.find('.modal-body').load("<?php // echo url_for('@get_formulario_evento_ajax')?>");
//            }
//            
//        });
        
        

    });
</script>