// Event List Displayer, based on:
// 
// jQuery Plugin Boilerplate
// A boilerplate for jumpstarting jQuery plugins development
// version 1.1, May 14th, 2011
// by Stefan Gabos

(function($) {

    $.eventList = function(element, options) {

        var defaults = {
            foo: 'bar',
            onFoo: function() {}
        };

        var plugin = this;

        plugin.settings = {};

        var $element   = $(element),
             element   = element,
             eventList = [];

        plugin.init = function() {
            plugin.settings = $.extend({}, defaults, options);
            
            $element.scrollTop(0);
            
            // Agrego eventos a la lista
            
            $.get(plugin.settings['initialEventsUrl'], function(data){
                for(var i=0, c=data.length; i<c; i++)
                    $element.append( createEventHolder(data[i]) );
            });
            
            $element.on('scroll', onScrollBehaviour);
            
            /* Manejo el boton cerrar de cada evento */
        
            $element.on("click", "button", onEventEraseBehaviour);
            
        };

        plugin.foo_public_method = function() {
            // code goes here
        };

        var onEventEraseBehaviour = function( event ) {
            event.preventDefault();
            var boton = $(this);
            
            var evtId = boton.siblings("input").val();

            // Lanzo ajax req para eliminar el evento. Si me da ok, entonces 
            // elimino el elemento padre, sino lanzo error
            $.ajax(plugin.settings['eraseEventUrl'],{
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
                        $("#calendar").fullCalendar( 'removeEvents' , evtId);

                    }
                }
            });

        };

        var createEventCloseButton = function(){
            return $("<button type=\"button\" class=\"close invisible removeEventButton\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        };
        
        var createEventHeader = function (fecha_inicio_formateada){
            return $("<h6>"+fecha_inicio_formateada+"</h6>");
        };
        
        var createEventTitle = function (titulo){
            return $("<h4>"+titulo+"</h4>")
                    .attr({
                        'class': "list-group-item-heading"
                    });
        };
        
        var createEventDescription = function (descripcion){
            return $("<p>"+descripcion+"</p>")
                    .attr({
                        'class': "list-group-item-text"
                    });
        };
        
        var createEventHiddenInputId = function (id){
            return $("<input>")
                    .attr({
                        'id': "evento_id",
                        'type': "hidden",
                        'value': id,
                        'name': "evento[id]"
                    });
        };
        
        var createEventHiddenInputIniDate = function (fecha_inicio){
            return $("<input>")
                    .attr({
                        'id': "evento_inicio",
                        'type': "hidden",
                        'value': fecha_inicio,
                        'name': "evento[inicio]"
                    });
        };


        var createEventHolder = function(eventData) {
            return $("<a>")
                .attr({
                    'href': "#!",
                    'class': "list-group-item"
                })
                .append(createEventCloseButton())
                .append(createEventHeader(eventData['inicio_formateado']))
                .append(createEventTitle(eventData['titulo']))
                .append(createEventDescription(eventData['descripcion']))
                .append(createEventHiddenInputId(eventData['id']))
                .append(createEventHiddenInputIniDate(eventData['inicio']));
            
        };

        var onScrollBehaviour = function(){
            
//            console.log($element.scrollTop(), $element.innerHeight(), $element[0].scrollHeight); return;
            
            if($element.scrollTop() + $element.innerHeight() >= $element[0].scrollHeight){
               
               var eventList       = $element,
                   lastInputId     = eventList.find("a:last-child > input#evento_id"),
                   lastInputFecha  = eventList.find("a:last-child > input#evento_inicio"),
                   url = plugin.settings['nextPageOfEventsUrl'];
           
               $.get(url,
                     {id: lastInputId.val(), fecha: lastInputFecha.val()},
                     function(data){
                        if(data.c > 0){
                            // eventList.append(data.links);
                            for(var i=0, c=data.c; i<c; i++)
                                eventList.append( createEventHolder(data['eventos'][i]) );
                        }
                        else {
                            eventList.off('scroll');
                        }
                     }
               );
               
            }
        };
        

        plugin.init();

    };

    $.fn.eventList = function(options) {

        return this.each(function() {
            if (undefined == $(this).data('eventList')) {
                var plugin = new $.eventList(this, options);
                $(this).data('eventList', plugin);
            }
        });

    };

})(jQuery);

