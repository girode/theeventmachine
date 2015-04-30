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
    this.status = "init";
    
    this.indicator
            .on( "trackValidationStatus.success", { statusIndicator: this }, this.statusValidCallback)
            .on( "trackValidationStatus.error", { statusIndicator: this }, this.statusInvalidCallback);
}
 
ValidationStatusIndicator.prototype.statusValidCallback = function(event, data) {
    var stat = event.data.statusIndicator;
    stat.indicator.css('background', 'green');
};
    
ValidationStatusIndicator.prototype.statusInvalidCallback = function(event, data) {
    var stat = event.data.statusIndicator;
    
    for(var i=0, c=data.errors.length; i<c; i++){

        if(data.errors[i]['field_id'] === stat.inputElem.attr('id'))
            stat.indicator.css('background', 'red');
    }
    
};
 
ValidationStatusIndicator.prototype.setStatus = function(newStatus) {
    this.status = newStatus;
    return this;
};

ValidationStatusIndicator.prototype.beInvalid = function() {
    return this.setStatus("error").statusInvalidCallback(this);
};

ValidationStatusIndicator.prototype.beValid = function() {
    return this.setStatus("success").statusValidCallback(this);
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
        onError: function() {}
    };

    myPlugin = (function (options) {

        function myPlugin(handler, options) {
            this.handler = handler;

            // plugin variables.
            this.validationStatusIndicators = [];
            
            // Extend default options.
            $.extend(true, this, defaultOptions, options);

            // Bind methods.
            this.update   = __bind(this.update, this);
            this.onSubmit = __bind(this.onSubmit, this);
            this.init     = __bind(this.init, this);
            this.clear    = __bind(this.clear, this);

            // Listen to submit event
            this.handler.on('submit.trackValidationStatus', this.onSubmit);
            
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

        // Example API function.
        myPlugin.prototype.augmentedPostFunc = function(plug) {
            return function (data, textStatus, jqXHR){
                
                if(plug.formHasErrors(data)){
                    for (var i = 0, c = plug.validationStatusIndicators.length;
                             i < c;
                             i++) {
                        plug.validationStatusIndicators[i].indicator.trigger( "trackValidationStatus.error", [ data ] );
                    }
                    
                    plug.onError(data);
                } else {
                    for (var i = 0, c = plug.validationStatusIndicators.length;
                             i < c;
                             i++) {
                        plug.validationStatusIndicators[i].indicator.trigger( "trackValidationStatus.success", [ data ] );
                    }
                    
                    plug.onSuccess(data);
                }
                
            };
        };
        
        myPlugin.prototype.formHasErrors = function (data) {
            return data.errors.length;
        };
        
        // Main method.
        myPlugin.prototype.init = function () {
            var excluded = this.excludedItems;
            
            var inputs = this.handler.find('input, textarea').not(excluded),
                plug   = this;
            
            inputs.each(function( index ) {
                
                var inputElem = $(this), newDiv = plug.createStatusDiv(inputElem);

                plug.validationStatusIndicators.push(new ValidationStatusIndicator (newDiv, inputElem));
                plug.addStatusDiv(newDiv, inputElem);
                
            });
    
        };

        myPlugin.prototype.createStatusDiv = function ($inputElem) {
            return $("<div>")
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
                .attr('id', $inputElem.attr('id').replace('evento', 'error'));
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




