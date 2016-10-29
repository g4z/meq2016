<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Jenssegers\Date\Date;
use GuzzleHttp\Client as HttpClient;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Collections\CellCollection;
use App\Models\UsgsEventRecord;

class FetchUsgsDataJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    // private $url = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_hour.csv';
    private $url = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_day.csv';
    // private $url = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_month.csv';

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

        $data = $this->loadCsvFileData();
        // $data = $this->loadCsvFileDataTest();

        foreach ($data as $row) {

            // ignore non 'earthquake' events
            if ($row->type != 'earthquake') {
                continue;
            }

            // ignore non-local events
            if (!$this->isLocalEvent($row)) {
                continue;
            }

            // find or create the event model
            $model = UsgsEventRecord::where('usgs_id', $row->id)->first();
            if ($model) {

                // if record already exists and has not 
                // been updated, ignore it and continue
                if (    Date::parse($row->updated) <= 
                        Date::parse($model->record_updated_at)
                ) {
                    continue;
                }

            } else {
                $model = new UsgsEventRecord();
            }

            $model->event_at = Date::parse($row->time);
            $model->record_updated_at = Date::parse($row->updated);
            $model->usgs_id = $row->id;
            $model->place = $row->place;
            $model->latitude = $row->latitude;
            $model->longitude = $row->longitude;
            $model->depth = $row->depth;
            $model->magnitude = $row->mag;
            
            $model->save();

        }

    }

    /**
     * Downloads a file.
     *
     * @throws \Exception
     *
     * @return Maatwebsite\Excel\Collections\RowCollection
     */
    private function loadCsvFileData() {

        // computer local tmpfile path
        $filepath = storage_path(sprintf('csv/%s.csv', md5((new Date())->__toString())));

        // Guzzle has a bug here?????
        // @see: http://stackoverflow.com/questions/39162814/is-guzzle-prepending-lines-to-my-downloaded-text-csv-file
        // $client = new HttpClient();
        // $result = $client->request('GET', $this->url/*, ['save_to' => $filepath]*/);
        // if ($result->getStatusCode() !== 200) {
            // throw new \Exception("Failed loading URL: {$this->url}");
        // }

        $content = file_get_contents($this->url);
        if (!$content) {
            throw new \Exception("Failed loading URL: {$this->url}");
        }

        File::put($filepath, $content, true);
        unset($content);

        // read all data from the CSV file
        // newest events are at the top
        // so we reverse the collection
        $data = Excel::load($filepath)->get()->reverse();

        unlink($filepath);

        return $data;

    }

    /**
     * Method for development
     *
     * @return Maatwebsite\Excel\Collections\RowCollection
     */
    private function loadCsvFileDataTest() {
        $buffer = gzdecode(File::get(resource_path('sample-files/all_month.csv.gz')));
        $filepath = tempnam(sys_get_temp_dir(), md5(microtime(true)));
        File::put($filepath, $buffer);
        $data = Excel::load($filepath)->get()->reverse();
        unlink($filepath);
        return $data;
    }

    /**
     * Determines if the event is local to us
     *
     * @param Maatwebsite\Excel\Collections\CellCollection $event The event record
     *
     * @return boolean True if local event, False otherwise.
     */
    private function isLocalEvent(CellCollection $event) {
        return (    $event->latitude > 42.0
                    && $event->latitude < 44.0
                    && $event->longitude > 11
                    && $event->longitude < 14);
    }

}
