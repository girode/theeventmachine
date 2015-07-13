/*!
 * jQuery Sieve v0.3.0 (2013-04-04)
 * http://rmm5t.github.io/jquery-sieve/
 * Copyright (c) 2013 Ryan McGeary; Licensed MIT
 */

;(function ( $, window, document, undefined ) {
    "use strict";
    
    // Create the defaults once
    var pluginName = "exsieve",
        defaults = {
            searchInput: null,
            searchTemplate: "<div><label>Search: <input type='text'></label></div>",
            itemSelector: "tbody tr",
            textSelector: null,
            toggle: function (item, match) {
                return item.toggle(match);
            },
            complete: function () { }
        };

    // The actual plugin constructor
    function ExSieve ( element, options ) {
        this.element = element;
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.filterList = {};
        this.init();
    }
    
    
    // Avoid ExSieve.prototype conflicts
    $.extend(ExSieve.prototype, {
        init: function () {
            
            if (!this.settings.searchInput) {
                var searchBar = $(this.settings.searchTemplate);
                this.settings.searchInput = searchBar.find("input");
                // Locates searchBar before container
                $(this.element).before(searchBar);
            }
        
            this.settings.searchInput.on("keyup.sieve change.sieve", this.onKeyStroke(this));
            
        },
        compact: function (array) {

            var results = [];

            for (var i = 0, len = array.length; i < len; i++) {
                if (array[i]) {
                  results.push(array[i]);
                }
            }

            return results;
        },
        onKeyStroke: function (plugin) {
            return function(){ // (event)
                var settings  = plugin.settings;
                
                // Assumes settings.searchInput to be a jQuery object
                var query = plugin.compact(settings.searchInput.val().toLowerCase().split(/\s+/));
                
                plugin.sieve(query);
            };
        },
        sieve: function(query){ // Expects array of terms to look for
            
            var container = $(this.element), 
                settings  = this.settings,    
                items     = container.find(settings.itemSelector),
                filterList = this.filterList;
    
            items.each(function () {
                var cells, q, text, match = true, item = $(this);

                // Finds text inside elements to be filtered
                if (settings.textSelector) {
                    cells = item.find(settings.textSelector);
                    text = cells.text().toLowerCase();
                } else {
                    text = item.text().toLowerCase();
                }

                // Performs search of query in elements
                for (var i = 0, len = query.length; i < len; i++) {
                    q = query[i];
                    match && (match = text.indexOf(q) >= 0);
                }
                
                // busco en "los filtros predeterminados"
                for(var key in filterList){
                    match && (match = text.indexOf(filterList[key]) >= 0);
                }
                
                return settings.toggle(item, match);
            });
            
            return settings.complete();
        },
        
        addToFilterList: function (){
            this.filterList[arguments[0]] = arguments[1];  
            this.onKeyStroke(this)();
        },
        
        removeFromFilterList: function (){
            delete this.filterList[arguments[0]]; 
            this.onKeyStroke(this)();
        }
        
        
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    
    // Adapted to allow for calling methods
    
    $.fn[ pluginName ] = function (options) {
        
        // slice arguments to leave only arguments after function name
        var args = Array.prototype.slice.call(arguments, 1);
        
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new ExSieve(this, options));
            } else {
                var instance = $(this).data("plugin_" + pluginName);
                
                if(typeof options === 'string' && (options === 'addToFilterList' || 'removeFromFilterList')) {
                    instance[options].apply(instance, args);
                }
            }
        });
    };

})( jQuery, window, document );