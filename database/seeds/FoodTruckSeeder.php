<?php

use Illuminate\Database\Seeder;
use SpotzCity\Resource;
use SpotzCity\ResourceCategoryLink;
use SpotzCity\ResourceCategory;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

class FoodTruckSeeder extends Seeder
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
      $csv = new parseCSV('database/seeds/data/Food Truck Distributors.csv');

      $log->info('Detected superuser: '.env('APP_SUPERUSER'));

      // Pull category entry
      $category = ResourceCategory::where('name', 'Food Trucks')->firstOrCreate();

      // Iterate through entries
      foreach ($csv->data as $key => $data) {
        $log->info($data['Company Name'].": Starting record");

        $resource = new Resource;

        // Set data, use global superuser as user_id
        $log->info($data['Company Name'].": Setting fields");
        $resource->user_id = env('APP_SUPERUSER');
        $resource->name = $data['Company Name'];
        $resource->website = $data['Website'];
        $resource->city = $data['City'];
        $resource->state = $data['State'];
        $resource->phone = $data['Phone'];
        $resource->approved = true;

        // Save Record
        $log->info($data['Company Name'].": Saving record");
        $resource->save();

        // Associate 'Energy' category
        $log->info($data['Company Name'].": Associating category");
        $r_cat_link = new ResourceCategoryLink;
        $r_cat_link->resource_category_id = $category->id;
        $resource->categories()->save($r_cat_link);
      }
    }
}
