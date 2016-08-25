<?php
/*
   0 => "__construct"
  1 => "set_registry"
  2 => "__toString"
  3 => "__destruct"
  4 => "get_item_tags"
  5 => "get_base"
  6 => "sanitize"
  7 => "get_feed"
  8 => "get_id"
  9 => "get_title"
  10 => "get_description"
  11 => "get_content"
  12 => "get_category"
  13 => "get_categories"
  14 => "get_author"
  15 => "get_contributor"
  16 => "get_contributors"
  17 => "get_authors"
  18 => "get_copyright"
  19 => "get_date"
  20 => "get_updated_date"
  21 => "get_local_date"
  22 => "get_gmdate"
  23 => "get_updated_gmdate"
  24 => "get_permalink"
  25 => "get_link"
  26 => "get_links"
  27 => "get_enclosure"
  28 => "get_enclosures"
  29 => "get_latitude"
  30 => "get_longitude"
  31 => "get_source"

 */
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchUsgsDataJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    // private $url = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/significant_hour.atom';
    private $url = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/significant_day.atom';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $feed = \Feeds::make($this->url);

        foreach ($feed->get_items() as $item) {

            $magnitude = $this->parseMagnitudeValue($item);
            
            $data = [
                'title' => $item->get_title(),
                'lat' => $item->get_latitude(),
                'lon' => $item->get_longitude(),
                'magnitude' => $magnitude,
                // 'date' => $item->get_date(),
                // 'updated_date' => $item->get_updated_date(),
                // 'local_date' => $item->get_local_date(),
                // 'gmdate' => $item->get_gmdate(),
            ];

            dd($data);

        }
    }

    //SimplePie_Item
    private function parseMagnitudeValue($item) {
        $buffer = $item->get_category(1)->get_term();
        return floatval(str_replace('Magnitude ', '', $buffer));
    }
}
