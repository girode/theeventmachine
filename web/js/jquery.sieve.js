/*!
 * jQuery Sieve v0.3.0 (2013-04-04)
 * http://rmm5t.github.io/jquery-sieve/
 * Copyright (c) 2013 Ryan McGeary; Licensed MIT
 */


(function() {
    var $ = jQuery;

    $.fn.sieve = function(options) {
      
        var compact = function(array) {

            var results = [];

            for (var i = 0, len = array.length; i < len; i++) {
                if (array[i]) {
                  results.push(array[i]);
                }
            }

            return results;
        };
        
        return this.each(function () {
            var container, searchBar, settings;

            container = $(this);

            settings = $.extend({
                searchInput: null,
                searchTemplate: "<div><label>Search: <input type='text'></label></div>",
                itemSelector: "tbody tr",
                textSelector: null,
                toggle: function (item, match) {
                    return item.toggle(match);
                },
                complete: function () { }
            }, options);


            if (!settings.searchInput) {
                searchBar = $(settings.searchTemplate);
                settings.searchInput = searchBar.find("input");
                // Locates searchBar before container
                container.before(searchBar);
            }


            return settings.searchInput.on("keyup.sieve change.sieve", function () {
                var query = compact($(this).val().toLowerCase().split(/\s+/)),
                    items = container.find(settings.itemSelector);
                
                items.each(function () {
                    var cells, q, text, match = true, item = $(this);
                    
                    if (settings.textSelector) {
                        cells = item.find(settings.textSelector);
                        text = cells.text().toLowerCase();
                    } else {
                        text = item.text().toLowerCase();
                    }
                    
                    for (var i = 0, len = query.length; i < len; i++) {
                        q = query[i];
                        match && (match = text.indexOf(q) >= 0);
                    }
                    
                    return settings.toggle(item, match);
                });
                
                return settings.complete();
            });
        });
        
    };

}).call(this);