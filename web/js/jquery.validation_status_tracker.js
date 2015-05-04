/*!
  jQuery Validation Status Tracker plugin
  @name jquery.validation_status_tracker.js
  @author Rode Gabriel (gabriel_rode@hotmail.com)
  @version 1.0
  @date 28/04/2015
  @category jQuery Plugin
  @copyright (c) 2013 Rode Gabriel
  @license Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
*/

function ValidationStatusIndicator (indicator, inputElem) {
    this.indicator   = indicator; // round div
    this.inputElem   = inputElem; 
    this.status      = "init";
    this.oldColor    = this.indicator.css('color');
    
    this.indicator
            .on( "trackValidationStatus.success", { statusIndicator: this }, this.beValid)
            .on( "trackValidationStatus.error", { statusIndicator: this }, this.beInvalid);
}
 
ValidationStatusIndicator.prototype.setStatus = function(newStatus) {
    this.status = newStatus;
    return this;
};

ValidationStatusIndicator.prototype.reset = function() {
    this.indicator.tooltip('destroy');
    this.indicator.removeClass()
                  .css('color', this.oldColor);
          
    return this.setStatus("init");
};


ValidationStatusIndicator.prototype.beInvalid = function(event, error_message) {
    var stat = event.data.statusIndicator;
    return stat.setStatus("error").statusInvalidCallback(stat, error_message);
};

ValidationStatusIndicator.prototype.beValid = function(event, data) {
    var stat = event.data.statusIndicator;
    return stat.setStatus("success").statusValidCallback(stat, data);
};

ValidationStatusIndicator.prototype.statusValidCallback = function(stat, data) {
    stat.indicator.css('color', 'green')
                  .attr("class", "glyphicon glyphicon-ok");
    
    stat.indicator.tooltip('destroy');
    
    return stat;
};
    
ValidationStatusIndicator.prototype.statusInvalidCallback = function(stat, error_message) {
    stat.indicator.css('color', 'red')
                  .attr("class", "glyphicon glyphicon-remove");
    
    stat.indicator.tooltip({
        title: error_message
    });
    
    return stat;
};


(function ($) {

    var myPlugin, defaultOptions, __bind;

    __bind = function (fn, me) {
        return function () {
            return fn.apply(me, arguments);
        };
    };

    // Plugin default options.
    defaultOptions = {
        onSuccess: function() {},
        onError: function() {},
        globalStatusIndicator: $('<div class="alert alert-danger" role="alert">').hide()
    };

    myPlugin = (function (options) {

        function myPlugin(handler, options) {
            this.handler = handler;

            // plugin variables.
            this.validationStatusIndicators = {};
            
            // Extend default options.
            $.extend(true, this, defaultOptions, options);

            // Bind methods.
            this.update   = __bind(this.update, this);
            this.onSubmit = __bind(this.onSubmit, this);
            this.onCancel = __bind(this.onCancel, this);
            this.init     = __bind(this.init, this);
            this.clear    = __bind(this.clear, this);

            this.cancelElement = $(this.cancelSelector) || this.handler;

            // Listen to submit event
            this.handler.on('submit.trackValidationStatus', this.onSubmit);
            this.cancelElement.on('hide.bs.modal', this.onCancel);
        }
        

        // Method for updating the plugins options.
        myPlugin.prototype.update = function (options) {
            $.extend(true, this, options);
        };

        // This timer ensures that layout is not continuously called as window is being dragged.
        myPlugin.prototype.onSubmit = function (event) {
            event.preventDefault();
            var $form = this.handler,
                 plug = this;
            
            $.post($form.attr('action'), $form.serialize(), this.augmentedPostFunc(plug), 'json');
            
        };

       
        myPlugin.prototype.augmentedPostFunc = function(plug) {
            return function (data, textStatus, jqXHR){
                
                var indicators = plug.validationStatusIndicators;
                
                if(plug.formHasErrors(data)){
                    
                    for(var fieldKey in indicators){
                        if(data.errors[fieldKey]){
                            indicators[fieldKey].indicator.trigger( 
                                "trackValidationStatus.error" ,
                                [ data.errors[fieldKey].message ] 
                            );
                        } else {
                            indicators[fieldKey].indicator.trigger( "trackValidationStatus.success", [ data ] );
                        }
                    }
                    
                    // Deal with global errors
                    if(plug.formHasGlobalErrors(data)){
                        plug.hideGlobalStatusIndicator();
                        plug.clearGlobalErrors();

                        for(var i=0, c=data.errors.global.length; i<c; i++)
                            plug.addGlobalError(data.errors.global[i]);

                        plug.showGlobalStatusIndicator();
                    }
                    
                    plug.onError(data);
                    
                } else {
                    
                    plug.resetStatusIndicators();
                    plug.onSuccess(data);
                }
                
            };
        };
        
        myPlugin.prototype.resetStatusIndicators = function () {
            this.hideGlobalStatusIndicator();
            this.clearGlobalErrors();
            
            for(var indicator in this.validationStatusIndicators){
                this.validationStatusIndicators[indicator].reset();
            }
            
            this.handler.get(0).reset();
        };
        
        myPlugin.prototype.formHasErrors = function (data) {
            return data.status === 'error';
        };
        
        myPlugin.prototype.formHasGlobalErrors = function (data) {
            return this.formHasErrors(data) && data.global;
        };
        
        myPlugin.prototype.hideGlobalStatusIndicator = function () {
            return this.globalStatusIndicator.hide();
        };
        
        myPlugin.prototype.showGlobalStatusIndicator = function () {
            return this.globalStatusIndicator.show();
        };
        
        myPlugin.prototype.clearGlobalErrors = function () {
            return this.globalStatusIndicator.empty();
        };
        
        myPlugin.prototype.addGlobalError = function (error_text) {
            return this.globalStatusIndicator
                        .append('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>')
                        .append('<span class="sr-only">Error: </span>')
                        .append(document.createTextNode('  ' + error_text))
                        .append("<br>");
        };
        
        // Main method.
        myPlugin.prototype.init = function () {
            var excluded = this.excludedItems;
            
            this.handler.prepend(this.globalStatusIndicator);
            
            var inputs = this.handler.find('input, textarea').not(excluded),
                plug   = this;
            
            inputs.each(function( index ) {
                
                var inputElem = $(this), newDiv = plug.createStatusDiv(inputElem);

                plug.validationStatusIndicators[inputElem.attr('id')] = new ValidationStatusIndicator (newDiv, inputElem);
                plug.addStatusDiv(newDiv, inputElem);
                
            });
            
        };

        
        myPlugin.prototype.onCancel = function (event) {
            this.resetStatusIndicators();
        };        
          
        myPlugin.prototype.createStatusDiv = function ($inputElem) {

            return $("<span>")
                .attr({
                    'id': $inputElem.attr('id').replace('evento', 'error'),
                    'data-toggle': "tooltip",
                    'data-placement': "top",
                    'aria-hidden': "true"
                });
            
        };

        myPlugin.prototype.parentIsDatetimePicker = function(parent){
            var parent_id = parent.attr('id'), ret = false;
            
            if(typeof parent_id !== 'undefined'){
                if(parent_id.lastIndexOf('datetimepicker', 0) === 0)
                    ret = true;
            }
            
            return ret;
        };
        
        myPlugin.prototype.typeIsCheckbox = function($inputElem){
            var elemType = $inputElem.attr('type');
            return (typeof elemType !== 'undefined') && (elemType === 'checkbox');
        };

        myPlugin.prototype.addStatusDiv = function (newDiv, $inputElem) {
            var parent = $inputElem.parent();
                
            if(this.parentIsDatetimePicker(parent))
                parent.before(newDiv);
            else if (this.typeIsCheckbox($inputElem))
                parent.append(newDiv);
            else
                $inputElem.before(newDiv);
            
        };

        // Clear event listeners and time outs.
        myPlugin.prototype.clear = function () {
            this.handler.off('submit.trackValidationStatus', this.onSubmit);
        };

        return myPlugin;
    })();

    $.fn.trackValidationStatus = function (options) {
        // Create a myPlugin instance if not available.
        if (!this.trackValidationStatusInstance) {
            this.trackValidationStatusInstance = new myPlugin(this, options || {});
        } else {
            this.trackValidationStatusInstance.update(options || {});
        }

        // Init plugin.
        this.trackValidationStatusInstance.init();

        // Display items (if hidden) and return jQuery object to maintain chainability.
        return this.show();
    };
})(jQuery);




