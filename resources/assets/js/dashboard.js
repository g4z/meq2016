
(function($) {

    'use strict';

    // Path to the data API
    let url = '/api/v1/latest';

    // determine the format for the full event date
    let format = 'hh:mm:ss dddd MMMM Do YYYY';

    // store language
    let language;

    // store refresh rate
    let rate;

    // store timezone
    let timezone;

    // handle for interval
    let intervalHandle;

    // store uuid of most recent
    let since;

    // setup the update interval
    function startInterval(seconds) {
        if (intervalHandle) {
            intervalHandle = null;
        }
        intervalHandle = setInterval(function() {
            update();
        }, ((seconds * 60) * 1000));
    }

    // function to create each event row
    function createEventRow(event) {

        let event_time_utc = moment(event.event_at).locale(language).tz('UTC');
        let event_time_utc_label = event_time_utc.locale(language).fromNow();
        let event_time_utc_string = event_time_utc.locale(language).format(format);
        
        let event_time_local = moment(event.event_at).locale(language).tz(timezone);
        let event_time_local_label = event_time_local.locale(language).fromNow();
        let event_time_local_string = event_time_local.locale(language).format(format);
        
        // FIXME force one line :/
        event_time_local_label = event_time_local_label.replace(/\s/g, '&nbsp;');

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

    // this function is called every 'rate' seconds
    function update() {

        // configure request params
        let data = {};
        
        if (since) { 
            data.since = since
        }

        // do the request
        $.ajax({
            url: url,
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

    // .ajax callback
    function onError (jqXHR, textStatus, errorThrown) {
        console.log('Error:' + textStatus);
        console.log(errorThrown);
    }
    
    // .ajax callback
    function onSuccess (data, textStatus, jqXHR ) {
        // loop through new events adding a new row for each
        $.each(data, function(index, event) {
            let $row = createEventRow(event);
            $row.hide();
            $('table > tbody').prepend($row);
            $row.fadeIn('slow');
            since = event.uuid;
        });
    }
    
    // .ajax callback
    function onComplete (jqXHR, textStatus) {}

    // handle for select interval option
    function onRateSelect(minutes) {
        minutes = parseInt(minutes);
        switch (minutes) {
            case 1:
            case 5:
            case 15:
            case 30:
                rate = minutes;
                cookies('rate', rate);
                startInterval(rate);
                $('body').removeClass('is-menu-visible'); // hide menu
            break;
            default:
                console.log('Invalid rate selected: ' + minutes);
            break;
        }
    }

    // handle for select language option
    function onLanguageSelect(language) {
        switch (language) {
            case 'en':
            case 'it':
                cookies('language', language);
                location.reload();
            break;
            default:
                console.log('Invalid language selected: ' + language);
            break;
        }
    }

    $(function() {

        // get the current timezone
        timezone = moment.tz.guess() || 'UTC';

        // get the current language
        language = cookies('language') 
                        ? cookies('language')
                        : $('meta[name=language]').attr('content');

        // get the refresh rate
        if (cookies('rate')) {
            rate = parseInt(cookies('rate'));
        } else {
            rate = parseInt($('meta[name=rate]').attr('content'));
            cookies('rate', rate)
        }

        // set the language radio buttons
        switch (language) {
            case 'it':
                $('#language-it').prop('checked', true);
            break;
            case 'en':
            default:
                $('#language-en').prop('checked', true);
            break;
        }

        // setup the rate/interval buttons
        switch (rate) {
            case 1:    // 1min
                $('#rate-1m').prop('checked', true);
            break;
            case 5:   // 5 min
                $('#rate-5m').prop('checked', true);
            break;
            case 15:   // 15 min
                $('#rate-15m').prop('checked', true);
            break;
            case 30:  // 30 min
                $('#rate-30m').prop('checked', true);
            break;
        }

        // configure select refresh rate event handlers
        $('.rate-selector').click(function(event) {
            onRateSelect(event.currentTarget.value);
        });
        
        // configure select language event handlers
        $('.language-selector').click(function(event) {
            onLanguageSelect(event.currentTarget.value);
        });

        // start scheduled update
        startInterval(rate);

        // do initial update
        update();

    });

})(jQuery);
