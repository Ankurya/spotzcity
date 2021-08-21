<?php

use Illuminate\Database\Seeder;
use SpotzCity\Conference;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;


class NewConferencesSeeder extends Seeder
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

      $csv = fopen('database/seeds/data/Local SpotzCity Conferences.csv', 'r');
      $mapping = [
        "Category" => 0,
        "Event Name" => 1,
        "City" => 2,
        "State" => 3,
        "Attendance" => 4,
        "Exhibitors" => 5,
        "Date" => 6,
        "Description" => 7
      ];

      while( ($data = fgetcsv($csv)) !== false ) {
        $log->info($data[$mapping['Event Name']].": Starting record");

        if( $data[$mapping['Event Name']] === 'Event Name' ) continue;

        $conference = Conference::firstOrNew( ['name' => utf8_encode($data[$mapping['Event Name']])] );

        // Set data
        $log->info($data[$mapping['Event Name']].": Setting data points");
        $conference->description = utf8_encode($data[$mapping['Description']]);
        $conference->location = utf8_encode($data[$mapping['City']]).' '.utf8_encode($data[$mapping['State']]);
        $conference->industry = utf8_encode($data[$mapping['Category']]);
        $conference->approved = true;

        // Detect Date format (either "M DD-DD, YYYY" or "D-MMM-YY")
        $log->info($data[$mapping['Event Name']].": Interpreting dates");
        $dates = explode( '-', trim($data[$mapping['Date']]) );
        $start = Carbon::parse("{$dates[0]}, 2020");
        $end = Carbon::parse("{$dates[1]}, 2020");

        $conference->starts = $start;
        $conference->ends = $end;

        $conference->geocodeLocation();

        $log->info($data[$mapping['Event Name']].": Saving record".PHP_EOL);
        $conference->save();
      }
      fclose($csv);
    }

}
