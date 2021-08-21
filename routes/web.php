<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index')
  ->name('Home');
//Homepage clone  
/* Route::get('/dev', 'HomeController@dev')
  ->name('Home'); */

Route::get('/dashboard', 'HomeController@dashboard')
  ->name('Dashboard')
  ->middleware('auth');

Route::get('/search', 'SearchController@index')
  ->name('Search');

Route::post('/query', 'SearchController@search');

Route::get('/search-ad', 'SearchController@getAd');

Route::get('/create-admin', 'UserController@create')
  ->name('Create Admin')
  ->middleware('auth');

Route::post('/create-admin', 'UserController@store')
  ->name('Store Admin')
  ->middleware('auth');

Route::get('/edit-user-info/{id?}', 'UserController@edit')
  ->name('Edit User Info')
  ->middleware('auth');

Route::post('/edit-user-info/{id?}', 'UserController@update')
  ->name('Update User Info')
  ->middleware('auth');

Route::get('/logout', 'HomeController@logout')
  ->name('Logout')
  ->middleware('auth');

Route::get('/business/{slug}', 'BusinessController@show')
  ->name('View Business');

Route::post('/homePageSignUp', 'BusinessController@homePageSignUp');

Route::get('/business-analytics/{id}', 'BusinessController@businessAnalytics')
  ->name('Business Analytics');

Route::get('/subscribe', 'BusinessController@subscribe')
  ->name('Subscribe');

Route::post('/subscribe-add-card', 'BusinessController@createBillingRecord')
  ->name('Subscribe - Create Record');

Route::post('/update-business-subscription', 'BusinessController@updateBusinessSubscription')
  ->name('Subscribe - Update Subscription');

Route::get('/cancel-business-subscription', 'BusinessController@cancelBusinessSubscription')
  ->name('Subscribe - Cancel Subscription');

Route::get('/add-a-business', 'BusinessController@create')
  ->name('Add Business')
  ->middleware('auth');

Route::get('/edit-info/{id}', 'BusinessController@edit')
  ->name('Edit Business')
  ->middleware('auth');

Route::get('/reactivate-business/{id}', 'BusinessController@reactivate')
  ->name('Reactivate Business')
  ->middleware('auth');

Route::get('/deactivate-business/{id}', 'BusinessController@deactivate')
  ->name('Deactivate Business')
  ->middleware('auth');


Route::get('/deactivate-business-admin/{id}', 'BusinessController@deactivate_admin')
  ->name('DeactivateAdmin Business')
  ->middleware('auth');


Route::get('/your-businesses', 'BusinessController@index')
  ->name('Index Business')
  ->middleware('auth');

Route::get('/sale-info/{id?}', 'BusinessController@editSaleInfo')
  ->name('Edit Sale Info')
  ->middleware('auth');

Route::post('/sale-info/{id?}', 'BusinessController@storeOrUpdateSaleInfo')
  ->name('Update Sale Info')
  ->middleware('auth');

Route::get('/events-and-specials/{id?}', 'BusinessEventController@edit')
  ->name('Events and Specials')
  ->middleware('auth');

Route::get('/claim-business/{id}', 'BusinessController@claim')
  ->name('Claim Business')
  ->middleware('auth');

Route::get('/write-review/{business_id}', 'ReviewController@create')
  ->name('Create Review')
  ->middleware('auth');

Route::post('/write-review/{business_id}', 'ReviewController@store')
  ->name('Store Review')
  ->middleware('auth');

Route::get('/edit-review/{business_id}', 'ReviewController@edit')
  ->name('Edit Review')
  ->middleware('auth');

Route::post('/edit-review/{business_id}', 'ReviewController@update')
  ->name('Update Review')
  ->middleware('auth');

Route::post('/claim-business/{id}/send-card', 'BusinessController@sendPostcard')
  ->name('Send Verificaton')
  ->middleware('auth');

Route::get('/verify', 'BusinessController@showVerifyBusinessForm')
  ->name('Verify Business')
  ->middleware('auth');

Route::post('/verify', 'BusinessController@verifyCode')
  ->name('Verify Code')
  ->middleware('auth');

Route::post('/business', 'BusinessController@store')
  ->name('Create Business')
  ->middleware('auth');

Route::post('/business/{id}', 'BusinessController@update')
  ->name('Update Business')
  ->middleware('auth');

Route::get('/download-event/{id}', 'BusinessEventController@downloadEvent')
  ->name('Download Event')
  ->middleware('auth');

Route::get('/ads', 'AdController@index')
  ->name('Ads')
  ->middleware('auth');

Route::get('/create-ad/{type}', 'AdController@create')
  ->name('Create Ad')
  ->middleware('auth');

Route::post('/submit-ad', 'AdController@store')
  ->name('Store Ad')
  ->middleware('auth');

Route::post('/update-ad/{id}', 'AdController@update')
  ->name('Update Ad')
  ->middleware('auth');

Route::get('/approve-ad/{id}', 'AdController@approve')
  ->name('Approve Ad')
  ->middleware('auth');

Route::get('/deactivate-ad/{id}', 'AdController@deactivate')
  ->name('Deactivate Ad')
  ->middleware('auth');

Route::get('/ad-redirect/{id}', 'AdController@handleRedirect')
  ->name('Ad Redirect');


// Subscriptions

Route::get('/manage-subscriptions', 'SubscriptionController@index')
  ->name('Manage Subscriptions')
  ->middleware('auth');

Route::get('/manage-subscriptions/{id}', 'SubscriptionController@viewInvoices')
  ->name('View Invoices')
  ->middleware('auth');

Route::post('/manage-subscriptions/add-card/{ad_id?}', 'SubscriptionController@addCard')
  ->name('Add Card')
  ->middleware('auth');

Route::get('/manage-subscriptions/set-default/{card_id}', 'SubscriptionController@setDefaultCard')
  ->name('Set Default Card')
  ->middleware('auth');

Route::get('/manage-subscriptions/delete-card/{card_id}', 'SubscriptionController@deleteCard')
  ->name('Delete Card')
  ->middleware('auth');

Route::get('/manage-subscriptions/create-ad-subscription/{ad_id}/{card_id?}', 'SubscriptionController@activateAd')
  ->name('Activate Ad')
  ->middleware('auth');

Route::get('/manage-subscriptions/create-resources-subscription/resources/{card_id?}', 'SubscriptionController@activateResources')
  ->name('Activate Resources')
  ->middleware('auth');

Route::get('/manage-subscriptions/delete-resources-subscription/delete', 'SubscriptionController@deactivateResources')
  ->name('Deactivate Resources')
  ->middleware('auth');


Route::get('/analytics', 'BusinessController@analytics')
  ->name('Analytics')
  ->middleware('auth');

Route::get('/user/{id}', 'UserController@show')
  ->name('User Profile')
  ->middleware('auth');


// Conferences

Route::get('/conferences', 'ConferencesController@index')
  ->name('Conferences')
  ->middleware('auth');

Route::get('/conferences/add-conference', 'ConferencesController@create')
  ->name('Create Conference')
  ->middleware('auth');

Route::get('/conferences/{id}', 'ConferencesController@edit')
  ->name('Edit Conference')
  ->middleware('auth');

Route::post('/conferences/add-conference', 'ConferencesController@store')
  ->name('Store Conference')
  ->middleware('auth');

Route::post('/conferences/{id}', 'ConferencesController@update')
  ->name('Update Conference')
  ->middleware('auth');


// Resources

Route::get('/resources', 'ResourcesController@index')
  ->name('Resources')
  ->middleware('auth');

Route::post('/resources/search', 'ResourcesController@search')
  ->name('Search Resources')
  ->middleware('auth');

Route::post('/resources', 'ResourcesController@create')
  ->name('Resources')
  ->middleware('auth');

Route::get('/resources/{id}', 'ResourcesController@edit')
  ->name('Edit Resource')
  ->middleware('auth');

Route::post('/resources/{id}', 'ResourcesController@update')
  ->name('Update Resource')
  ->middleware('auth');


// Admin Routes

Route::get('/admin/search', 'AdminController@search')
  ->name('Admin Search')
  ->middleware('auth');

// Route::get('/admin/search', 'AdminController@search')
//   ->name('Admin Search')
//   ->middleware('auth');


// Route::get('/deactivate-business/{id}', 'BusinessController@deactivate')
//   ->name('Deactivate Business')
//   ->middleware('auth');



Route::post('/admin/search/users', 'AdminController@searchUsers')
  ->name('Admin Search Users')
  ->middleware('auth');

Route::post('/admin/search/businesses', 'AdminController@searchBusinesses')
  ->name('Admin Search Businesses')
  ->middleware('auth');

Route::get('/admin/users-report', 'AdminController@UserReport')
  ->name('Users Reports')
  ->middleware('auth');

Route::get('/admin/categories', 'AdminController@categories')
  ->name('Admin Categories')
  ->middleware('auth');


Route::post('/admin/categories/create', 'AdminController@createCategory')
  ->name('Admin Categories - Create')
  ->middleware('auth');

Route::post('/admin/categories/update', 'AdminController@updateCategory')
  ->name('Admin Categories - Update')
  ->middleware('auth');

Route::get('/admin/categories/delete/{id}', 'AdminController@deleteCategory')
  ->middleware('auth');

Route::get('/admin/commodities/delete/{id}', 'AdminController@deleteCommodity')
  ->middleware('auth');

  Route::resource('projects', 'AdminController@show');



// Supplementary Pages
Route::get('/about', 'HomeController@about')
  ->name('About');

Route::get('/faq', 'HomeController@faq')
  ->name('FAQ');

Route::get('/support', 'HomeController@support')
  ->name('Support');

Route::post('/support', 'HomeController@createContactRequest')
  ->name('Create Contact Request');


// CMS
Route::get('/p/{slug}', 'PageController@show')
  ->name('Show Page');

Route::get('/pages', 'PageController@index')
  ->name('Pages')
  ->middleware('auth');

Route::get('/pages/create', 'PageController@create')
  ->name('Create Page')
  ->middleware('auth');

Route::post('/pages/create', 'PageController@store')
  ->name('Store Page')
  ->middleware('auth');

Route::get('/pages/edit/{id}', 'PageController@edit')
  ->name('Edit Page')
  ->middleware('auth');

Route::post('/pages/edit/{id}', 'PageController@update')
  ->name('Update Page')
  ->middleware('auth');

Route::get('/pages/delete/{id}', 'PageController@destroy')
  ->name('Delete Page')
  ->middleware('auth');

Route::get('/blogs', 'PageController@blogIndex')
  ->name('Blogs')
  ->middleware('auth');

Route::get('/blog', 'PageController@blogList')
  ->name('Blog');

//Ajax Routes (Activity Feed)
Route::get('/activity/near-me/{page}', 'HomeController@activityNearMe');
Route::get('/activity/following/{page}', 'HomeController@activityFollowing')->middleware('auth');


//Ajax Routes (Hot Spotz)
Route::get('/hot-spotz/{categories}', 'HomeController@getHotSpotz');


//Ajax Routes (Business Events/Specials)
Route::get('/business/{id}/events-and-specials', 'BusinessEventController@index')->middleware('auth');
Route::post('/business/{id}/events-and-specials', 'BusinessEventController@store')->middleware('auth');
Route::patch('/business/{business_id}/events-and-specials/{id}', 'BusinessEventController@update')->middleware('auth');
Route::delete('/business/{business_id}/events-and-specials/{id}', 'BusinessEventController@delete')->middleware('auth');


//Ajax Routes (Review Responses)
Route::post('/review-reply/{review_id}', 'ReviewController@createResponse')->middleware('auth');
Route::patch('/review-reply/{review_id}', 'ReviewController@updateResponse')->middleware('auth');
Route::delete('/review-reply/{review_id}', 'ReviewController@deleteResponse')->middleware('auth');


//Ajax Routes (Business)
Route::get('/business/{id}/follow', 'FollowController@create')->middleware('auth');
Route::delete('/business/{id}/follow', 'FollowController@delete')->middleware('auth');
Route::delete('/business/{id}/remove-featured-photo', 'BusinessController@deleteFeaturedPhoto')->middleware('auth');


//Stripe Webhooks
Route::post('/hooks', 'StripeHooksController@receiveEvent');

// add new 0 billing users
Route::get('/add-new-user', 'UserController@addNewUser')
  ->name('Add New User')
  ->middleware('auth');

  Route::post('/create-new-user', 'UserController@storeNewUser')
  ->name('Store New User')
  ->middleware('auth');
  
// add route for the partner
Route::get('/create-partner', 'PartnerController@create')
  ->name('Create Partner')
  ->middleware('auth');

Route::post('/create-partner', 'PartnerController@store')
  ->name('Store Partner')
  ->middleware('auth');

  Route::get('/partner', 'PartnerController@showPartner')
  ->name('Partner');


// add route for chats
/*    Route::get('/chat/{slug}', 'UserController@chatFunc')
  ->name('Chat & Message')
  ->middleware('auth');

  Route::get('/chat', 'UserController@businessChat')->name('Chat & Message')->middleware('auth');
*/
Route::get('/chat', 'MessagesController@chatRoom')->name('Chat & Message')->middleware('auth');
Route::get('/chat-setting', 'MessagesController@chatSetting')->name('Chats Settings')->middleware('auth');
Route::get('/chat/{user_id}', 'MessagesController@addList')->name('Send Message')->middleware('auth');
Route::post('/changeUserStatus', 'MessagesController@changeUserStatus')->middleware('auth');
Route::post('/blockuser', 'MessagesController@blockuser')->middleware('auth');
Route::get('/unblock/{block_user_id}', 'MessagesController@unblock')->middleware('auth');  
  
Route::post('/chat-msg-send', 'UserController@chatMsgSend'); 


Route::get('/load-latest-messages', 'MessagesController@getLoadLatestMessages');

Route::post('/send', 'MessagesController@postSendMessage');

Route::get('/fetch-old-messages', 'MessagesController@getOldMessages');




Auth::routes();
