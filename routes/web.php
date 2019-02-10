<?php

use App\Jobs\RefreshSiteMapJob;
use App\Jobs\SuckDataJob;
use App\Model\Notification;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Route::redirect('/', '/home');



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SOCIAL LOGIN(GUEST) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('log_in/{social}/{remember_me}','Auth\LoginController@socialLogin')
	->where('social','twitter|facebook|linkedin|google|github');

Route::get('login/{social}/callback','Auth\LoginController@handleProviderCallback')
	->where('social','twitter|facebook|linkedin|google|github');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SOCIAL LOGIN(GUEST) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// HOOKS /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', 'PageControllers\DonationController@whatmovieshouldiwatch')->middleware('blog_if_not_logged_in');//PUBLIC
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// HOOKS /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// OTHER PAGES ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('home/{lang?}', 'PageControllers\homeController@home')
	->where('lang', config('constants.supported_languages.for_web_php'));//GUEST

Route::get('person/{id}/{lang?}', 'PageControllers\personController@person')
	->where('lang', config('constants.supported_languages.for_web_php'));//AUTH

Route::get('donation/{lang?}', 'PageControllers\DonationController@donate')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC
Route::get('change_insta_language/{lang}', 'PageControllers\DonationController@change_insta_language')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC

Route::get('privacy-policy/{lang?}', 'PageControllers\PrivacypolicyController@privacypolicy')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC

Route::get('faq/{lang?}', 'PageControllers\FaqController@faq')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC

Route::get('not-found', function () {
    return view('errors.404');
});//PUBLIC
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// OTHER PAGES ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// MOVIE PAGE (PULBIC) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('movie/{id}/{lang?}/{secondary_lang?}', 'PageControllers\movieController@movie')->middleware('id_dash_moviename')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_user_movie_record/{movie}','PageControllers\movieController@get_user_movie_record');//IMPLEMENT AUTH
Route::get('api/get_movie_lists/{movie}','PageControllers\movieController@get_movie_lists');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// MOVIE PAGE (PULBIC) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SERIES PAGE (PULBIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('series/{id}/{lang?}/{secondary_lang?}', 'PageControllers\seriesController@series')->middleware('id_dash_seriesname')
	->where('lang', config('constants.supported_languages.for_web_php'));
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SERIES PAGE (PULBIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// LIST PAGE (PULBIC) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('list/{id}', 'PageControllers\listController@list')->middleware('id_dash_listname');
Route::get('createlist/{id?}', 'PageControllers\listController@create_list')->middleware('id_dash_listname');

Route::get('deletelist/{id}', 'PageControllers\listController@delete_list');
Route::get('api/likelist/{id}', 'PageControllers\listController@like_list');
Route::get('api/unlikelist/{id}', 'PageControllers\listController@unlike_list');
Route::post('createlist', 'PageControllers\listController@post_createlist');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// LIST PAGE (PULBIC) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// RECOMMENDATIONS PAGE (PUBLIC) ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('recommendations/{user?}', 'PageControllers\recommendationsController@recommendations');

Route::get('api/get_last_parties','ApiControllers\SearchController@get_last_parties');
Route::get('api/remove_from_parties/{user}','ApiControllers\SearchController@remove_from_parties');
Route::get('api/add_to_parties/{user}','ApiControllers\SearchController@add_to_parties');
Route::post('api/get_top_rateds/{lang?}','PageControllers\recommendationsController@get_top_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_series_top_rateds/{lang?}','PageControllers\recommendationsController@get_series_top_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_pemosu/{lang?}','PageControllers\recommendationsController@get_pemosu')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_series_pemosu/{lang?}','PageControllers\recommendationsController@get_series_pemosu')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_momosu','PageControllers\recommendationsController@get_momosu');
Route::post('api/get_series_momosu','PageControllers\recommendationsController@get_series_momosu');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// RECOMMENDATIONS PAGE (PUBLIC) ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SEARCH PAGE (AUTH) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('search/{lang?}', 'PageControllers\searchController@search')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_pluck_id/{mode}','ApiControllers\SearchController@get_pluck_id');
Route::get('api/search_lists/{text}','ApiControllers\SearchController@search_lists');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SEARCH PAGE (AUTH) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// PROFILE PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('profile/{user}/{lang?}', 'PageControllers\ProfileController@profile')->middleware('id_dash_username')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_rateds/{rate}/{user}/{lang}','PageControllers\ProfileController@get_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_series_rateds/{rate}/{user}/{lang}','PageControllers\ProfileController@get_series_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_laters/{user}/{lang}','PageControllers\ProfileController@get_laters')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_series_laters/{mode}/{user}/{lang}','PageControllers\ProfileController@get_series_laters')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_bans/{user}/{lang}','PageControllers\ProfileController@get_bans')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_series_bans/{user}/{lang}','PageControllers\ProfileController@get_series_bans')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_lists/{list_mode}/{user}','PageControllers\ProfileController@get_lists');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// PROFILE PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SETTINGS PAGE (AUTH) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('account', 'PageControllers\accountController@account');
Route::get('account/password/{lang?}', 'PageControllers\accountController@password')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('account/interface/{lang?}', 'PageControllers\accountController@interface')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::post('account', 'PageControllers\accountController@change_profile');
Route::post('account/password', 'PageControllers\accountController@change_password');
Route::post('account/interface', 'PageControllers\accountController@change_interface');
Route::get('theme/{mode?}', 'PageControllers\accountController@theme');
Route::get('api/get_cover_pics/{lang}','PageControllers\accountController@get_cover_pics')
	->where('lang', config('constants.supported_languages.for_web_php'));
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SETTINGS PAGE (AUTH) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// API RATE (AUTH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::apiResource('api/bans','ApiControllers\BanController');
Route::apiResource('api/laters','ApiControllers\LaterController');
Route::apiResource('api/rateds','ApiControllers\RatedController');
Route::get('api/search_users/{text?}','ApiControllers\SearchController@search_users');
Route::get('api/get_quick_rate/{lang}','ApiControllers\RatedController@get_quick_rate');
Route::get('api/get_watched_movie_number','ApiControllers\RatedController@get_watched_movie_number');
Route::get('api/suck_movie/{movie_id}','ApiControllers\JobController@suck_movie');
Route::post('api/tooltip','ApiControllers\LevelController@tt_manipulate');
Route::apiResource('api/series_bans','ApiControllers\SeriesBanController');
Route::apiResource('api/series_laters','ApiControllers\SeriesLaterController');
Route::apiResource('api/series_rateds','ApiControllers\SeriesRatedController');
Route::apiResource('api/series_seens','ApiControllers\SeriesSeenController');
Route::post('api/destroy_review','ApiControllers\ReviewController@destroy_review');
Route::post('api/show_reviews','ApiControllers\ReviewController@show_reviews');
Route::apiResource('api/reviews','ApiControllers\ReviewController');
Route::apiResource('api/review_like','ApiControllers\ReviewLikeController');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// API RATE (AUTH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('suckData', function(){
	SuckDataJob::dispatch()->onQueue("low");
	return 'sucking data.';
});
Route::get('refreshSitemap', function(){
	RefreshSiteMapJob::dispatch()->onQueue("high");
	return 'refreshing sitemaps.';
});
//Route::get('refreshSitemap','Architect\Architect@refreshSitemap');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('test', function(){
	/*return dd(DB::table('users')
	->leftjoin('laters', 'laters.user_id', 'users.id')
	->select(
		'users.id',
		'users.facebook_id',
		'users.name',
		'users.tt_navbar',
		'users.tt_movie',
        DB::raw('COUNT(laters.id) as later_count')
	)
	->groupBy('users.id')
    ->orderBy(DB::raw('COUNT(laters.id)'), 'DESC')
	->paginate(20));*/
	if(Auth::id() == 7){
		Notification::updateOrCreate(
		    ['mode' => 1, 'user_id' => 2, 'multi_id' => 77],
		    ['is_seen' => 0]
		);
	}
});
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////