<div id="main" class="row">
    <div class="col-md-9" id="calendar"></div>
    <div class="col-md-3 list-group" id="ticker">
        <div id="eventList"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // initialize the calendar...

        $("#calendar").fullCalendar({
            events: {
                url: '<?php echo url_for('@get_eventos_ajax')?>'        
            }
        });
        
        /* Agrego botones custom al calendario */
        
        var createButton = $(
            "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#eventFormModal\">" +
                "<span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span> " +
                "Crear nuevo evento" +
            "</button>");
        
        var createDiv = $("<div id=\"new-event-form-div\" data-toggle=\"tooltip\" class=\"form-group\">")
                            .append(createButton);
        
        createDiv.tooltip({
            title: "Agrega un nuevo evento al calendario"
        });
       
        var searchButton = $("<input type='text' id='filterBtn' class='form-control input-sm' placeholder='Filtrar eventos'>");
        
        // Agrego div con los nuevos botones

        $("div.fc-toolbar > div.fc-right")
            .append(createDiv)
            .append(searchButton)
            .addClass('form-inline');


        //DOING: Implementar un scroller y la paginacion correspondiente
        
        $('div#eventList')
            .eventList({
                initialEventsUrl: "<?php echo url_for("agenda/getEventosParaListaAjax");?>",
                nextPageOfEventsUrl: "<?php echo url_for("agenda/getNextEventPageAjax");?>",
                eraseEventUrl: "<?php echo url_for("@borrar_evento_ajax")?>",
            }).sieve({ 
                itemSelector: "a.list-group-item",
                searchInput: searchButton
            });
        

    });
</script>