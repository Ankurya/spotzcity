<?php

use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity')->delete();

        factory(SpotzCity\Activity::class, 400)->states('business.created')->create();
        factory(SpotzCity\Activity::class, 400)->states('review.created')->create();
        factory(SpotzCity\Activity::class, 5)->states('review_response.created')->create();
        factory(SpotzCity\Activity::class, 5)->states('event.created')->create();
    }
}
