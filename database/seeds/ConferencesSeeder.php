<?php

use Illuminate\Database\Seeder;
use SpotzCity\Conference;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;


class ConferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Log
      $log = new Logger('seeder');
      $log->pushHandler(new StreamHandler('logs/seeder.log', Logger::DEBUG));

      $csv = new parseCSV('database/seeds/data/trimmed_conferences_data.csv');
      foreach ($csv->data as $key => $data) {
        $log->info($data['Conference'].": Starting record");

        $conference = new Conference;

        // Set data
        $log->info($data['Conference'].": Setting data points");
        $conference->name = $data['Conference'];
        $conference->venue = strlen($data['Venue']) > 255 ? substr($data['Venue'], 0, 255) : $data['Venue'];
        $conference->website = $data['Link'];
        $conference->description = $data['Conference Detail'];
        $conference->location = $data['Locations'];
        $conference->approved = true;

        // Detect Date format (either "M DD-DD, YYYY" or "D-MMM-YY")
        $log->info($data['Conference'].": Interpreting dates");
        if(strpos($data['Dates'], ',') !== false){
          $log->info($data['Conference'].": 'M DD-DD, YYYY' detected");
          $exploded = explode(' ', $data['Dates']);
          $days = explode('-', $exploded[1]);
          $conference->starts = Carbon::parse("$exploded[0] $days[0], $exploded[2]")->addYear();
          $conference->ends = Carbon::parse("$exploded[0] $days[1] $exploded[2]")->addYear();
          $log->info($data['Conference'].": Starts $exploded[0] $days[0], $exploded[2]");
          $log->info($data['Conference'].": Ends $exploded[0] $days[1] $exploded[2]");
        } else{
          $log->info($data['Conference'].": 'D-MMM-YY' detected");
          $exploded = explode('-', $data['Dates']);
          $conference->starts = Carbon::parse("$exploded[1] $exploded[0], $exploded[2]")->addYear();
          $conference->ends = Carbon::parse("$exploded[1] $exploded[0], $exploded[2]")->addYear();
          $log->info($data['Conference'].": Starts $exploded[1] $exploded[0], $exploded[2]");
          $log->info($data['Conference'].": Ends $exploded[1] $exploded[0], $exploded[2]");
        }

        $conference->geocodeLocation();

        $log->info($data['Conference'].": Saving record".PHP_EOL);
        $conference->save();

      }
    }

}
