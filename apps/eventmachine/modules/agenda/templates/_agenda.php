<div class="row">
    <div class="col-md-9">
        <div id="calendar"></div>
    </div>
    <div class="col-md-3">
        
        <div id="new-event-form-div">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventFormModal">Nuevo Evento</button>
        </div>
        
        <div id="ticker" class="list-group">
            <div class="list-group">
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">List group item heading</h4>
                  <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">List group item heading</h4>
                  <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                </a>
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">List group item heading</h4>
                  <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                </a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        // initialize the calendar...

        $("#calendar").fullCalendar({
            events: '<?php echo url_for('@get_eventos_ajax')?>'
        })
        
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