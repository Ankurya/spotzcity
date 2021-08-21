<?php

use Illuminate\Database\Seeder;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

use SpotzCity\Business;
use SpotzCity\ECategory;
use SpotzCity\ECategoryLink;
use SpotzCity\Commodity;
use SpotzCity\CommodityLink;

class ILBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Map Commodities
      $commodities_map = [
        'Construction/Maintenance/Home' => Commodity::where('name', 'Construction/Maintenance')->first(),
        'Business/Finance' => Commodity::where('name', 'Business/Finance')->first(),
        'Business' => Commodity::where('name', 'Business/Finance')->first(),
        'Real' => Commodity::where('name', 'Real Estate')->first(),
        'Social' => Commodity::where('name', 'Social Services')->first(),
        'Transportation/Travel' => Commodity::where('name', 'Transportation')->first(),
        'Education/Training' => Commodity::where('name', 'Education/Training')->first(),
        'Restaurant/Food' => Commodity::where('name', 'Restaurant/Food')->first(),
        'Clothing/Apparel' => Commodity::where('name', 'Retail')->first(),
        'Technology' => Commodity::where('name', 'Technology')->first(),
        'Arts/Entertainment' => Commodity::where('name', 'Arts/Entertainment')->first(),
        'Automotive' => Commodity::where('name', 'Automotive')->first(),
        'Industrial' => Commodity::where('name', 'Industrial Goods/Services')->first(),
        'Legal' => Commodity::where('name', 'Legal')->first(),
        'Retail/Wholesale' => Commodity::where('name', 'Retail')->first(),
        'Medical/Health' => Commodity::where('name', 'Medical/Healthcare')->first(),
        'Wedding/Crafts' => Commodity::where('name', 'Wedding/Crafts')->first(),
        'Babies/Children' => Commodity::where('name', 'Babies/Children')->first(),
        'Hospitality' => Commodity::where('name', 'Hospitality')->first(),
        'Insurance' => Commodity::where('name', 'Insurance')->first(),
      ];

      // Map Entrepreneur Categories
      $categories_map = [
        'african american' => ECategory::where('name', 'Blackpreneur')->first(),
        'caucasian' => ECategory::where('name', 'Caucasianpreneur')->first(),
        'asian american' => ECategory::where('name', 'Asianpreneur')->first(),
        'latino american' => ECategory::where('name', 'Latinopreneur')->first(),
        'hispanic american' => ECategory::where('name', 'Latinopreneur')->first(),
        'native american' => ECategory::where('name', 'Nativepreneur')->first(),
        'veteran' => ECategory::where('name', 'Vetpreneur')->first(),
        'disabled' => ECategory::where('name', 'Disabledpreneur')->first(),
        'lgbtq' => ECategory::where('name', 'LGBTQpreneur')->first(),
      ];


      // Log
      $log = new Logger('seeder');
      $log->pushHandler(new StreamHandler('logs/seeder.log', Logger::INFO));
      $log->info('Beginning IL business seed');

      // Counts
      $successful = 0;
      $failed = 0;

      // Parse CSV
      $csv = new parseCSV('database/seeds/data/IL_Business.csv');
      foreach ($csv->data as $key => $data) {
        $log->info('Importing '. $data['Company Name']);

        // Verify req'd fields
        if(
          !$data['Company Name'] || !$data['Physical Address'] ||
          !$data['City'] || !$data['St'] || !$data['Zip'] ||
          !$data['Commodity'] || !$data['Ethnicity'] || $data['Ethnicity'] === "OTH"
        ){
          $log->error('Fields missing, aborting import of row');
          $failed++;
          continue;
        }

        // Set values
        $business = new Business;
        $business->user_id = env('APP_SUPERUSER');
        $business->name = $data['Company Name'];
        $business->address = $data['Physical Address'];
        $business->address_two = "";
        $business->city = $data['City'];
        $business->state = $data['St'];
        $business->zip = $data['Zip'];
        $business->phone = $data['Phone'];

        // Generate slug and geocode location
        $business->generateSlug();
        $geocode_result = $business->geocodeAddress();

        // If geocode fails, skip
        if(!$geocode_result){
          $log->error('Geocoding failed, aborting import of row');
          $failed++;
          continue;
        }

        // Create commodity association
        $log->info('Creating commidity association for '.$data['Commodity']);
        $commodity_name = explode(" ", $data['Commodity'])[0];
        $commodity_link = new CommodityLink;
        $commodity_id = @$commodities_map[$commodity_name]->id;
        if(!$commodity_id){
          $log->error('Commodity type unknown, aborting import of row');
          $failed++;
          continue;
        }
        $commodity_link->commodity_id = $commodity_id;

        // Create entrepreneur category association
        $log->info('Creating category association for '.$data['Ethnicity']);
        $category_link = new ECategoryLink;
        $category_id = @$categories_map[strtolower($data['Ethnicity'])]->id;
        if(!$category_id){
          $log->error('Category type unknown, aborting import of row');
          $failed++;
          continue;
        }
        $category_link->e_category_id = $category_id;

        // Save business and associations
        $log->info('Saving business and associations');
        $business->save();
        $business->e_categories()->save($category_link);
        $business->commodities()->save($commodity_link);

        // Check for vet or disabled or lgbtq
        if($data['Veteran']){
          $vet_link = new ECategoryLink;
          $vet_link->e_category_id = $categories_map['veteran']->id;
          $business->e_categories()->save($vet_link);
        }
        if($data['Disabled']){
          $dis_link = new ECategoryLink;
          $dis_link->e_category_id = $categories_map['disabled']->id;
          $business->e_categories()->save($dis_link);
        }
        if($data['LGBT']){
          $lgbt_link = new ECategoryLink;
          $lgbt_link->e_category_id = $categories_map['lgbtq']->id;
          $business->e_categories()->save($lgbt_link);
        }

        $log->info('Record successfully imported!');
        $successful++;
      }
      $log->info("Import complete. $successful successfully imported, $failed failed.");
    }
}
