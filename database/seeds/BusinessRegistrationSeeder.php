<?php

use Illuminate\Database\Seeder;
use SpotzCity\Resource;
use SpotzCity\ResourceCategoryLink;
use SpotzCity\ResourceCategory;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

class BusinessRegistrationSeeder extends Seeder
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
      $csv = new parseCSV();
      $csv->parse( 'database/seeds/data/BusinessRegistration.csv' );

      // Pull category entry
      $category = ResourceCategory::where('name', 'Business Registration')->firstOrCreate();

      // Iterate through entries
      foreach ($csv->data as $key => $data) {
        $log->info($data['Department'].": Starting record");

        $resource = new Resource;

        // Set data, use global superuser as user_id
        $log->info($data['Department'].": Setting fields");
        $resource->user_id = env('APP_SUPERUSER');
        $resource->name = $data['Department'];
        $resource->website = $data['Website'];
        $resource->city = $data['City'];
        $resource->state = $data['State'];
        $resource->phone = $data['Phone'];
        $resourced->approved = true;

        // Save Record
        $log->info($data['Department'].": Saving record");
        $resource->save();

        // Associate 'Energy' category
        $log->info($data['Department'].": Associating category");
        $r_cat_link = new ResourceCategoryLink;
        $r_cat_link->resource_category_id = $category->id;
        $resource->categories()->save($r_cat_link);
      }
    }
}
