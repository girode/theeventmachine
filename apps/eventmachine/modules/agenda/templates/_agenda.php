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
       
        var filterInput = $("<input>")
                .attr({
                    'type':  'text',
                    'id':    'filterBtn',
                    'class': 'form-control',
                    'placeholder': 'Filtrar eventos'
                });
        
        var searchDropdown = $("<div class=\"input-group-btn\">")
                .append("<button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">" +
                    "<span class=\"glyphicon glyphicon-filter\" aria-hidden=\"true\"></span>" +
                "</button>")
                .append(
                    "<ul class=\"dropdown-menu dropdown-menu-right\">" +
                        "<li class=\"dropdown-header\">Tiempo</li>" +
                        "<li><a id=\"filterCurrentMonth\"href=\"#!\">Este Mes</a></li>" +
                        "<li><a href=\"#!\">Este Año</a></li>" +
                        "<li class=\"dropdown-header\">Fuente</li>" +
                        "<li><a href=\"#!\">Facebook</a></li>" +
                        "<li><a href=\"#!\">G Calendar</a></li>" +
                    "</ul>"
                );        
        
        var searchDiv = $("<div class=\"form-group\">");
        
        $("<div class=\"input-group input-group-sm\">")
            .append(filterInput)
            .append(searchDropdown)
            .appendTo(searchDiv);
        
        // Agrego div con los nuevos botones

        $("div.fc-toolbar > div.fc-right")
            .append(createDiv)
            .append(searchDiv)
            .addClass('form-inline');

        $('div#eventList')
            .eventList({
                initialEventsUrl: "<?php echo url_for("agenda/getEventosParaListaAjax");?>",
                nextPageOfEventsUrl: "<?php echo url_for("agenda/getNextEventPageAjax");?>",
                eraseEventUrl: "<?php echo url_for("@borrar_evento_ajax")?>"
            }).exsieve({ 
                itemSelector: "a.list-group-item",
                searchInput: filterInput
            });
            
        $("a#filterCurrentMonth").toggleClick(function (){
            $('div#eventList').exsieve("addToFilterList", "text", "/<?php echo date('m/Y')?>");    
            $(this).addClass('activeEventFilter');
        }, function(){
            $('div#eventList').exsieve("removeFromFilterList", "text");
            $(this).removeClass('activeEventFilter');
        });    
            
    });
</script>