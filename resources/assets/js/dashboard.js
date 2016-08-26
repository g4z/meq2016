
(function($) {

    'use strict';

    let URL = '/api/v1/latest';
    let INTERVAL = 60;
    let FORMAT = 'hh:mm:ss dddd MMMM Do YYYY';

    $(function() {

        //determine current timezone
        if (!sessionStorage.getItem('timezone')) {
            var tz = moment.tz.guess() || 'UTC';
            sessionStorage.setItem('timezone', tz);
        }

        var timezone = sessionStorage.getItem('timezone');

        // store uuid of most recent
        let since = null;

        function createEventRow(event) {

            let event_time_utc = moment(event.event_at).tz('UTC');
            let event_time_utc_label = event_time_utc.fromNow();
            let event_time_utc_string = event_time_utc.format(FORMAT);
            
            let event_time_local = moment(event.event_at).tz(timezone);
            let event_time_local_label = event_time_local.fromNow();
            let event_time_local_string = event_time_local.format(FORMAT);
            
            let event_time_label_span = $('<span/>')
                                            .attr('title', event_time_local_string)
                                            .html(event_time_local_label);
            let $row = $('<tr/>');
            let $date = $('<td/>').append(event_time_label_span);
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
