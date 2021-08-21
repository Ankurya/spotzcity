<?php

use Illuminate\Database\Seeder;

use SpotzCity\User;
use SpotzCity\Ad;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Seed categories and commodities
      SpotzCity\ECategory::insert([
        [ 'name' => 'Arabpreneur' ],
        [ 'name' => 'Asianpreneur' ],
        [ 'name' => 'Blackpreneur' ],
        [ 'name' => 'Caucasianpreneur' ],
        [ 'name' => 'Dadpreneur' ],
        [ 'name' => 'Disabledpreneur' ],
        [ 'name' => 'Hispanicpreneur' ],
        [ 'name' => 'Jewishpreneur' ],
        [ 'name' => 'Kidpreneur' ],
        [ 'name' => 'Latinopreneur' ],
        [ 'name' => 'LGBTQpreneur' ],
        [ 'name' => 'Millenialpreneur' ],
        [ 'name' => 'Mompreneur' ],
        [ 'name' => 'Nativepreneur' ],
        [ 'name' => 'Seniorpreneur' ],
        [ 'name' => 'Womanpreneur' ],
        [ 'name' => 'Vetpreneur' ],
      ]);

      SpotzCity\Commodity::insert([
        [ 'name' => 'Advertising/Marketing' ],
        [ 'name' => 'Automotive' ],
        [ 'name' => 'Arts/Entertainment' ],
        [ 'name' => 'Babies/Children' ],
        [ 'name' => 'Business/Finance,' ],
        [ 'name' => 'Construction/Architecture/Maintenance/HVAC' ],
        [ 'name' => 'Community/Civic' ],
        [ 'name' => 'Education/Training' ],
        [ 'name' => 'Energy' ],
        [ 'name' => 'Event Planning/Coordination' ],
        [ 'name' => 'Home/Commercial Cleaning' ],
        [ 'name' => 'Hospitality' ],
        [ 'name' => 'Industrial Goods/Services' ],
        [ 'name' => 'Insurance' ],
        [ 'name' => 'Manufacturing' ],
        [ 'name' => 'Medical/Healthcare' ],
        [ 'name' => 'Legal' ],
        [ 'name' => 'Pets/Animals' ],
        [ 'name' => 'Real Estate' ],
        [ 'name' => 'Faith/Religion/Spiritual' ],
        [ 'name' => 'Restaurant/Food' ],
        [ 'name' => 'R&D/Military' ],
        [ 'name' => 'Retail' ],
        [ 'name' => 'Social Services' ],
        [ 'name' => 'Security' ],
        [ 'name' => 'Technology' ],
        [ 'name' => 'Transportation/Logistics' ],
        [ 'name' => 'Wedding/Crafts' ],
      ]);

      // Create default user accounts
      $regular = User::create([
        'first_name' => 'EJ',
        'last_name' => 'Rudy',
        'display_name' => 'EJ Rudy',
        'email' => 'ej@sequential.tech',
        'password' => bcrypt( 'password' )
      ]);

      $admin = User::create([
        'first_name' => 'EJ',
        'last_name' => 'Rudy',
        'display_name' => 'EJ Rudy',
        'email' => 'ej+admin@sequential.tech',
        'admin' => true,
        'password' => bcrypt( 'password' )
      ]);

      // Seed default ads
      $banner = Ad::create([
        'name' => 'Default Banner',
        'url' => 'spotzcity.com',
        'image' => 'ads/5490be7fb1acc670c21d113a98920e36.jpeg',
        'type' => 'default-banner',
        'active' => true,
        'approved' => true,
        'user_id' => 2
      ]);

      $sidebar1 = Ad::create([
        'name' => 'Default Sidebar',
        'url' => 'spotzcity.com',
        'image' => 'ads/87dff40192cb187b0843075d55c99bcc.jpeg',
        'type' => 'default-sidebar-1',
        'active' => true,
        'approved' => true,
        'user_id' => 2
      ]);

      $sidebar2 = Ad::create([
        'name' => 'Default Sidebar',
        'url' => 'spotzcity.com',
        'image' => 'ads/87dff40192cb187b0843075d55c99bcc.jpeg',
        'type' => 'default-sidebar-2',
        'active' => true,
        'approved' => true,
        'user_id' => 2
      ]);

      // Run Business seed
      $this->call([ InitBusinessSeeder::class ]);


      if( env('APP_ENV') === 'local' ) {
        // DB::table('reviews')->delete();
        // DB::table('e_category_links')->delete();
        // DB::table('commodity_links')->delete();
        // DB::table('businesses')->delete();
        // DB::table('users')->delete();

        // factory(SpotzCity\User::class, 500)->create();

        // factory(SpotzCity\User::class, 2000)->states('with_business')->create()->each(function($user){
        //   $business = $user->business()->save(factory(SpotzCity\Business::class)->states('verified')->make());
        //   $business->setLocationAttribute("$business->lng, $business->lat");
        //   $business->save();

        //   $e_categories = SpotzCity\ECategory::inRandomOrder()->take(rand(1,3))->get();
        //   foreach ($e_categories as $key => $category) {
        //     $link = new SpotzCity\ECategoryLink;
        //     $link->e_category_id = $category->id;
        //     $business->e_categories()->save($link);
        //   }

        //   $commodities = SpotzCity\Commodity::inRandomOrder()->take(rand(1,3))->get();
        //   foreach ($commodities as $key => $commodity) {
        //     $link = new SpotzCity\CommodityLink;
        //     $link->commodity_id = $commodity->id;
        //     $business->commodities()->save($link);
        //   }


        //   $rand = 0;
        //   while($rand < 9){
        //     $pulled_user = SpotzCity\User::inRandomOrder()->first();
        //     if($pulled_user->id != $user->id){
        //       factory(SpotzCity\Review::class)->create(['user_id' => $pulled_user->id, 'business_id' => $business->id]);
        //     }
        //     $rand = rand(1,10);
        //   }

        // });
      }
    }
}
