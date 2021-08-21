<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
|- User Factories
*/

$factory->define(SpotzCity\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
      'first_name' => $faker->firstName,
      'last_name' => $faker->lastName,
      'email' => $faker->unique()->safeEmail,
      'gender' => null,
      'display_name' => $faker->name,
      'has_business' => false,
      'picture' => null,
      'admin' => false,
      'password' => $password ?: $password = bcrypt('secret'),
      'remember_token' => str_random(10),
    ];
});

$factory->state(SpotzCity\User::class, 'with_business', function (Faker\Generator $faker) {
    return [
      'has_business' => true,
    ];
});

$factory->state(SpotzCity\User::class, 'admin', function (Faker\Generator $faker) {
    return [
      'admin' => true,
    ];
});


/*
|- Business Factories
*/

$factory->define(SpotzCity\Business::class, function (Faker\Generator $faker) {
    return [
      'name' => $faker->company,
      'slug' => $faker->slug,
      'address' => $faker->streetAddress,
      'address_two' => '',
      'city' => $faker->city,
      'state' => $faker->stateAbbr,
      'zip' => $faker->postcode,
      'phone' => $faker->phoneNumber,
      'for_sale' => false,
      'lat' => $faker->latitude,
      'lng' => $faker->longitude,
      'description' => $faker->paragraph,
      'url' => $faker->url,
      'verified' => false
    ];
});

$factory->state(SpotzCity\Business::class, 'verified', function (Faker\Generator $faker) {
    return [
      'verified' => true
    ];
});



/*
|- Activitiy Factories
*/

$factory->define(SpotzCity\Activity::class, function(Faker\Generator $faker){
    return [
      'created_at' => $faker->dateTime()
    ];
});

$factory->state(SpotzCity\Activity::class, 'business.created', function(Faker\Generator $faker){
    return [
      'type' => 'business.created',
      'business_id' => SpotzCity\Business::inRandomOrder()->first()->id
    ];
});

$factory->state(SpotzCity\Activity::class, 'review.created', function(Faker\Generator $faker){
    $review = SpotzCity\Review::inRandomOrder()->first();
    return [
      'type' => 'review.created',
      'review_id' => $review->id,
      'business_id' => $review->business->id,
      'user_id' => $review->user->id
    ];
});

$factory->state(SpotzCity\Activity::class, 'review_response.created', function(Faker\Generator $faker){
    $review_response = SpotzCity\ReviewResponse::inRandomOrder()->first();
    return [
      'type' => 'review_response.created',
      'review_response_id' => $review_response->id,
      'review_id' => $review_response->review->id,
      'business_id' => $review_response->business->id,
      'user_id' => $review_response->review->user->id
    ];
});

$factory->state(SpotzCity\Activity::class, 'event.created', function(Faker\Generator $faker){
    $event = SpotzCity\BusinessEvent::inRandomOrder()->first();
    return [
      'type' => 'event.created',
      'business_id' => $event->business->id,
      'business_event_id' => $event->id
    ];
});



/*
|- Review Factory
*/

$factory->define(SpotzCity\Review::class, function (Faker\Generator $faker) {
    return [
      'rating' => $faker->numberBetween(1, 5),
      'body' => $faker->paragraph
    ];
});
