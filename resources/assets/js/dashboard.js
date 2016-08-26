
(function($) {

    "use strict";

    let URL = '/api/v1/latest';
    let INTERVAL = 60;

    $(function() {

        // store uuid of most recent
        let since = null;

        function createEventRow(event) {
            let $row = $('<tr/>');
            let $date = $('<td/>').html(event.event_at);
            let $place = $('<td/>').html(event.place);
            let $magnitude = $('<td/>').html(event.magnitude);
            $row.append($date);
            $row.append($place);
            $row.append($magnitude);
            return $row;
        }

        function update() {

            let data = {};
            
            if (since) { 
                data.since = since
            }

            $.ajax({
                url: URL,
                method: 'GET',
                headers: {},
                data: data,
                dataType: 'json',
                timeout: 10000, 
                error: onError,
                success: onSuccess,
                complete: onComplete,
            });
        }

        function onError (jqXHR, textStatus, errorThrown) {
            console.log('Error:' + textStatus);
            console.log(errorThrown);
        }
        
        function onSuccess (data, textStatus, jqXHR ) {
            $.each(data, function(index, event) {
                let $row = createEventRow(event);
                $row.hide();
                $('table > tbody').prepend($row);
                $row.fadeIn('slow');
                since = event.uuid;
            });
        }
        
        function onComplete (jqXHR, textStatus) {}

        setInterval(function() {
            update();
        }, (INTERVAL * 1000));

        update();

    });

})(jQuery);
