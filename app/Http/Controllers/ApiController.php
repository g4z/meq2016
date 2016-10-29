<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\UsgsEventRecord;
use App\Http\Requests\GetLatestEventsRequest;
use Jenssegers\Date\Date;

class ApiController extends Controller
{
    public function getLatestEvents(GetLatestEventsRequest $request)
    {
        $since = $request->input('since');

        if ($since) {
            
            $last = UsgsEventRecord::select('id')
                                    ->where('uuid', $since)
                                    ->first();

            return UsgsEventRecord::where('id', '>', $last->id)
                                    ->orderBy('event_at')
                                    ->get();

        } else {

            $from = Date::now()->subWeek();

            return UsgsEventRecord::where('event_at', '>', $from)
                                    ->orderBy('event_at')
                                    ->get();

        }
    }
}
