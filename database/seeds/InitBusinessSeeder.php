<?php

use Illuminate\Database\Seeder;

use SpotzCity\Business;
use SpotzCity\ECategory;
use SpotzCity\Commodity;

class InitBusinessSeeder extends Seeder
{

    public function __construct() {

        // Define mappings for commodity categories in data
        $this->commodityMap = [
          'Advertising & Marketing' => 'Advertising/Marketing',
          'Automotive & Repair' => 'Automotive',
          'Art & Entertainment' => 'Arts/Entertainment',
          'Childcare & Development' => 'Babies/Children',
          'Business Consulting' => 'Business/Finance,',
          'Accounting, Banking & Finance' => 'Business/Finance,',
          'Community & Civic Organizations' => 'Community/Civic',
          'Sports & Recreation' => 'Community/Civic',
          'Building, Construction & Engineering' => 'Construction/Maintenance/HVAC',
          'Heating & Cooling' => 'Construction/Maintenance/HVAC',
          'Architecture & Design' => 'Construction/Maintenance/HVAC',
          'Fence Contractor' => 'Construction/Maintenance/HVAC',
          'Electrical' => 'Construction/Maintenance/HVAC',
          'Training & Development' => 'Education/Training',
          'Event Planning & Supplies' => 'Event Planning/Coordination',
          'Energy & Oil' => 'Energy',
          'Oil & Energy' => 'Energy',
          'Faith, Religion & Spiritual' => 'Faith/Religion/Spiritual',
          'Home & Commercial Cleaning' => 'Home/Commercial Services & Cleaning',
          'Landscaping & Snow Removal' => 'Home/Commercial Services & Cleaning',
          'Pest Control' => 'Home/Commercial Services & Cleaning',
          'Hotels & Hospitality' => 'Hospitality',
          'Industrial Services' => 'Industrial Goods/Services',
          'Insurance' => 'Insurance',
          'Manufacturing' => 'Manufacturing',
          'Furniture & Furniture Manufacturing' => 'Manufacturing',
          'Health & Fitness' => 'Medical/Healthcare',
          'Healthcare & Medicine' => 'Medical/Healthcare',
          'Attorney & Legal' => 'Legal',
          'Pets & Animals' => 'Pets/Animals',
          'Property & Real Estate' => 'Real Estate',
          'Catering, Food Services, Bars & Restaurants' => 'Restaurant/Food',
          'Clothing Apparel' => 'Retail',
          'Flowers & Flower Shops' => 'Retail',
          'Flower Shop' => 'Retail',
          'Office Equipment & Supplies' => 'Retail',
          'Shopping & Retail' => 'Retail',
          'Hair & Beauty' => 'Retail',
          'Translation' => 'Social Services',
          'Social Services' => 'Social Services',
          'Safety & Security' => 'Security',
          'Technology & Telecommunications' => 'Technology',
          'Environmental & Life Science' => 'Technology',
          'Print & Graphic Design' => 'Technology',
          'Media & Communications' => 'Technology',
          'Personal Services' => 'Technology',
          'Boats & Supplies' => 'Transportation/Logistics',
          'Logistics & Transportation' => 'Transportation/Logistics',
          'Hauling, Trucking & Disposal' => 'Transportation/Logistics',
          'Distributor' => 'Transportation/Logistics',
          'Packaging & Fulfillment' => 'Transportation/Logistics',
          'Moving & Storage' => 'Transportation/Logistics',
          'Warehousing' => 'Transportation/Logistics',
          'Military Consulting' => 'R&D/Military',
          'Aviation & Supplies' => 'R&D/Military',
          'Environmental & Life Science' => 'R&D/Military'
        ];

        // Define mappings for diversities
        $this->diversityMap = [
          'Woman' => 'Womanpreneur',
          'Black' => 'Blackpreneur',
          'Hispanic' => 'Hispanicpreneur',
          'Asian-Pacific' => 'Asianpreneur',
          'Asian-Indian' => 'Asianpreneur',
          'Veteran' => 'Vetpreneur',
          'Native American' => 'Nativepreneur',
          'Disabled' => 'Disabledpreneur'
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pull in team CSV
        $csv = array_map( 'str_getcsv', file(__DIR__.'/data/IL_IN.csv') );

        // Iterate rows
        foreach( $csv as $index => $data ) {

          // Skip header row
          if( $index === 0 ) continue;

          // Create new business, no owner
          $business = Business::firstOrNew([ 'name' => $data[0] ]);
          $business->user_id = 2;

          // If business has already been created, add diversity (sheet uses multiple rows for multiple diversities)
          if( $business->id ) {
            $diversity = ECategory::where( 'name', $this->diversityMap[ rtrim($data[7]) ] )->first();
            $business->e_categories()->create( ['e_category_id' => $diversity->id] );
            continue;
          }

          // If business has not been created and entry lacks service, skip
          if( !$business->id && !$data[1] ) continue;

          print_r( $data );

          // Set attributes
          $business->name = $data[0];
          $business->address = ucwords( strtolower($data[2]) );
          $business->city = ucwords( strtolower($data[3]) );
          $business->state = ucwords( strtolower($data[4]) );
          $business->zip = $data[5];

          // Generate slug and geocode
          $business->generateSlug();
          try {
            $business->geocodeAddress();
          } catch ( \Exception $e ) {
            // Can't find addy? Skippity.
            continue;
          }

          // Associate categories/diversities
          $commodity = Commodity::where( 'name', $this->commodityMap[ rtrim($data[1]) ] )->first();
          $diversity = ECategory::where( 'name', $this->diversityMap[ rtrim($data[7]) ] )->first();

          // Save
          $business->save();

          // Save associated categories/diversities
          $business->commodities()->create( ['commodity_id' => $commodity->id] );
          $business->e_categories()->create( ['e_category_id' => $diversity->id] );
        }
    }
}
