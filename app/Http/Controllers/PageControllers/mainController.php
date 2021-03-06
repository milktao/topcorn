<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class mainController extends Controller
{
    public static function get_legendary_garbage_movies($mode, $users, $sort)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $subq = DB::table('rateds')
        ->leftjoin('movies', 'movies.id', '=', 'rateds.movie_id')
        ->select(
            'movies.id',
            'movies.original_title as original_title',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.App::getlocale().'_title as title',
            'movies.'.App::getlocale().'_poster_path as poster_path',
            DB::raw('MAX(rateds.updated_at) as updated_at'),
            DB::raw('COUNT(movies.id) as count')
        )
        ->groupBy('movies.id')
        ->where('rateds.rate', '=', $mode);

        if($sort == 'newest'){
            $subq = $subq
            ->orderBy('updated_at', 'desc')
            ->orderBy('count', 'desc');
        }else{
            $subq = $subq
            ->orderBy('count', 'desc')
            ->orderBy('updated_at', 'desc');
        }

        if($users == 'following'){
            $subq = $subq
            ->leftjoin('follows', function ($join) {
                $join->on('rateds.user_id', '=', 'follows.object_id')
                ->where('follows.subject_id', '=', Auth::id())
                ->where('follows.is_deleted', '=', 0);
            })
            ->whereNotNull('follows.id');
        }

        $qqSql = $subq->toSql();

        $movies = DB::table('rateds')
        ->join(
            DB::raw('(' . $qqSql. ') as ss'),
            function($join) use ($subq) {
                $join->on('rateds.updated_at', '=', 'ss.updated_at')
                ->addBinding($subq->getBindings());
                $join->on('rateds.movie_id', '=', 'ss.id');
            }
        )
        ->leftjoin('users', 'users.id', '=', 'rateds.user_id')
        ->leftjoin('rateds as r2', function ($join) {
            $join->on('r2.movie_id', '=', 'ss.id')
            ->where('r2.user_id', '=', Auth::id());
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'ss.id')
            ->where('laters.user_id', '=', Auth::id());
        })
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'ss.id')
            ->where('bans.user_id', '=', Auth::id());
        })
        ->whereNull('bans.id')
        ->select(
            'ss.*',
            DB::raw('LEFT(users.name , 25) AS last_voter_name'),
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->paginate($pagination);

        foreach ($movies as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        }

        return $movies;
    }



    public static function get_legendary_garbage_series($mode, $users, $sort)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $subq = DB::table('series_rateds')
        ->leftjoin('series', 'series.id', '=', 'series_rateds.series_id')
        ->select(
            'series.id',
            'series.original_name as original_title',
            'series.vote_average',
            'series.vote_count',
            'series.first_air_date as release_date',
            'series.'.App::getlocale().'_name as name',
            'series.'.App::getlocale().'_poster_path as poster_path',
            DB::raw('MAX(series_rateds.updated_at) as updated_at'),
            DB::raw('COUNT(series.id) as count')
        )
        ->groupBy('series.id')
        ->where('series_rateds.rate', '=', $mode);

        if($sort == 'newest'){
            $subq = $subq
            ->orderBy('updated_at', 'desc')
            ->orderBy('count', 'desc');
        }else{
            $subq = $subq
            ->orderBy('count', 'desc')
            ->orderBy('updated_at', 'desc');
        }

        if($users == 'following'){
            $subq = $subq
            ->leftjoin('follows', function ($join) {
                $join->on('series_rateds.user_id', '=', 'follows.object_id')
                ->where('follows.subject_id', '=', Auth::id())
                ->where('follows.is_deleted', '=', 0);
            })
            ->whereNotNull('follows.id');
        }

        $qqSql = $subq->toSql();

        $series = DB::table('series_rateds')
        ->join(
            DB::raw('(' . $qqSql. ') as ss'),
            function($join) use ($subq) {
                $join->on('series_rateds.updated_at', '=', 'ss.updated_at')
                ->addBinding($subq->getBindings());
                $join->on('series_rateds.series_id', '=', 'ss.id');
            }
        )
        ->leftjoin('users', 'users.id', '=', 'series_rateds.user_id')
        ->leftjoin('series_rateds as r2', function ($join) {
            $join->on('r2.series_id', '=', 'ss.id')
            ->where('r2.user_id', '=', Auth::id());
        })
        ->leftjoin('series_laters', function ($join) {
            $join->on('series_laters.series_id', '=', 'ss.id')
            ->where('series_laters.user_id', '=', Auth::id());
        })
        ->leftjoin('series_bans', function ($join) {
            $join->on('series_bans.series_id', '=', 'ss.id')
            ->where('series_bans.user_id', '=', Auth::id());
        })
        ->select(
            'ss.*',
            DB::raw('LEFT(users.name , 25) AS last_voter_name'),
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'series_laters.id as later_id',
            'series_bans.id as ban_id'
        )
        ->paginate($pagination);

        foreach ($series as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        }

        return $series;
    }



    public static function get_airing_series($mode)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $series = DB::table('series')
        ->leftjoin('series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'series.id')
            ->where('series_rateds.user_id', '=', Auth::id());
        })
        ->leftjoin('series_laters', function ($join) {
            $join->on('series_laters.series_id', '=', 'series.id')
            ->where('series_laters.user_id', '=', Auth::id());
        })
        ->leftjoin('series_bans', function ($join) {
            $join->on('series_bans.series_id', '=', 'series.id')
            ->where('series_bans.user_id', '=', Auth::id());
        })
        ->select(
            'series.id as id',
            'series.original_name as original_title',
            'series.vote_average',
            'series.vote_count',
            'series.next_episode_air_date',
            DB::raw('DATEDIFF(series.next_episode_air_date, CURDATE()) AS day_difference_next'),
            'series.first_air_date as release_date',
            'series.'.App::getlocale().'_name as name',
            'series.'.App::getlocale().'_poster_path as poster_path',
            'series_rateds.id as rated_id',
            'series_rateds.rate as rate_code',
            'series_laters.id as later_id',
            'series_bans.id as ban_id'
        )
        ->orderBy('series.next_episode_air_date', 'asc')
        ->orderBy('series.popularity', 'desc');

        if($mode == 'watch later'){
            $series = $series
            ->whereBetween('series.next_episode_air_date', [Carbon::today(), Carbon::today()->addDays(300)])
            ->whereNotNull('series_laters.id');
        }else if($mode == 'all'){
            $series = $series
            ->whereBetween('series.next_episode_air_date', [Carbon::today(), Carbon::today()->addDays(7)]);
        }

        return $series->paginate($pagination);;
    }



    public static function get_popular_users($mode, $f_following)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $users = DB::table('users')
        ->select(
            'users.id as user_id',
            'users.name as name',
            'users.facebook_profile_pic as facebook_profile_path',
            'users.profile_pic as profile_path',
            DB::raw('COUNT(users.id) as count')
        )
        ->groupBy('users.id')
        ->orderBy('count', 'desc')
        ->orderBy('users.last_login', 'desc')
        ->orderBy('users.id', 'desc');

        if($mode == 'comment'){
            $users = $users
            ->leftjoin('reviews', function ($join) {
                $join->on('reviews.user_id', '=', 'users.id');
            })
            ->leftjoin('review_likes', function ($join) {
                $join->on('review_likes.review_id', '=', 'reviews.id')
                ->where('review_likes.is_deleted', '=', 0);
            })
            ->whereNotNull('review_likes.id');
        }else if($mode == 'list'){
            $users = $users
            ->leftjoin('listes', function ($join) {
                $join->on('listes.user_id', '=', 'users.id');
            })
            ->leftjoin('listlikes', function ($join) {
                $join->on('listlikes.list_id', '=', 'listes.id')
                ->where('listlikes.is_deleted', '=', 0);
            })
            ->whereNotNull('listlikes.id');
        }else if($mode == 'follow'){
            $users = $users
            ->leftjoin('follows', function ($join) {
                $join->on('follows.object_id', '=', 'users.id');
            })
            ->whereNotNull('follows.id');
        }

        if($f_following == 'following'){
            $users = $users
            ->leftjoin('follows as f2', function ($join) {
                $join->on('users.id', '=', 'f2.object_id')
                ->where('f2.subject_id', '=', Auth::id())
                ->where('f2.is_deleted', '=', 0);
            })
            ->whereNotNull('f2.id');
        }else if($f_following == 'follower'){
            $users = $users
            ->leftjoin('follows as f2', function ($join) {
                $join->on('users.id', '=', 'f2.subject_id')
                ->where('f2.object_id', '=', Auth::id())
                ->where('f2.is_deleted', '=', 0);
            })
            ->whereNotNull('f2.id');
        }

        return $users->paginate($pagination);
    }



    public static function get_popular_people($mode)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $people = DB::table('people')
        ->select(
            'people.id',
            'people.profile_path',
            'people.name',
            DB::raw('DATE(people.birthday) as birthday'),
            'people.deathday',
            'people.popularity',
            DB::raw('TIMESTAMPDIFF(YEAR, people.birthday, CURDATE()) AS age'),
            DB::raw('TIMESTAMPDIFF(YEAR, people.birthday, people.deathday) AS died_age')
        )
        ->orderBy('people.popularity', 'desc');

        if($mode == 'born today'){
            $people = $people
            ->whereMonth('people.birthday', Carbon::now()->month)
            ->whereDay('people.birthday', Carbon::now()->day);
        }else if($mode == 'died today'){
            $people = $people
            ->whereMonth('people.deathday', Carbon::now()->month)
            ->whereDay('people.deathday', Carbon::now()->day);
        }

        return $people->paginate($pagination);
    }



    public static function get_popular_lists($mode, $f_following)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $listes = DB::table('listes')
        ->leftjoin('users', function ($join) {
            $join->on('listes.user_id', '=', 'users.id');
        })
        ->leftjoin('listlikes', function ($join) {
            $join->on('listlikes.list_id', '=', 'listes.id')
            ->where('listlikes.is_deleted', '=', 0);
        })
        ->leftjoin('listitems as l1', function ($join) {
            $join->on('l1.list_id', '=', 'listes.id')
            ->where('l1.position', '=', 1);
        })
        ->leftjoin('movies as m1', 'm1.id', '=', 'l1.movie_id')
        ->leftjoin('listitems as l2', function ($join) {
            $join->on('l2.list_id', '=', 'listes.id')
            ->where('l2.position', '=', 2);
        })
        ->leftjoin('movies as m2', 'm2.id', '=', 'l2.movie_id')
        ->leftjoin('listitems as l3', function ($join) {
            $join->on('l3.list_id', '=', 'listes.id')
            ->where('l3.position', '=', 3);
        })
        ->leftjoin('movies as m3', 'm3.id', '=', 'l3.movie_id')
        ->leftjoin('listitems as l4', function ($join) {
            $join->on('l4.list_id', '=', 'listes.id')
            ->where('l4.position', '=', 4);
        })
        ->leftjoin('movies as m4', 'm4.id', '=', 'l4.movie_id')
        ->leftjoin('listitems as l5', function ($join) {
            $join->on('l5.list_id', '=', 'listes.id')
            ->where('l5.position', '=', 5);
        })
        ->leftjoin('movies as m5', 'm5.id', '=', 'l5.movie_id')
        ->leftjoin('listitems as l6', function ($join) {
            $join->on('l6.list_id', '=', 'listes.id')
            ->where('l6.position', '=', 6);
        })
        ->leftjoin('movies as m6', 'm6.id', '=', 'l6.movie_id')
        ->select(
            'listes.id',
            'listes.title',
            DB::raw('COUNT(listlikes.list_id) as like_count'),
            'listes.updated_at',
            DB::raw('LEFT(listes.entry_1 , 50) AS entry_1'),
            DB::raw('LEFT(listes.entry_1 , 51) AS entry_1_raw'),
            'm1.'.App::getlocale().'_poster_path as m1_poster_path',
            'm2.'.App::getlocale().'_poster_path as m2_poster_path',
            'm3.'.App::getlocale().'_poster_path as m3_poster_path',
            'm4.'.App::getlocale().'_poster_path as m4_poster_path',
            'm5.'.App::getlocale().'_poster_path as m5_poster_path',
            'm6.'.App::getlocale().'_poster_path as m6_poster_path'
        )
        ->where('listes.visibility', 1)
        ->groupBy('listes.id');

        if($mode == 'most liked'){
            $listes = $listes
            ->whereNotNull('listlikes.id')
            ->orderBy('like_count', 'desc')
            ->orderBy('listes.updated_at', 'desc');
        }else if($mode == 'newest'){
            $listes = $listes
            ->orderBy('listes.updated_at', 'desc');
        }

        if($f_following == 'following'){
            $listes = $listes
            ->leftjoin('follows as f2', function ($join) {
                $join->on('listes.user_id', '=', 'f2.object_id')
                ->where('f2.subject_id', '=', Auth::id())
                ->where('f2.is_deleted', '=', 0);
            })
            ->whereNotNull('f2.id');
        }

        $listes = $listes->paginate($pagination);

        foreach ($listes as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        }

        return $listes;
    }



    public static function get_popular_reviews($mode, $f_following)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $reviews = DB::table('users')
        ->leftjoin('reviews', function ($join) {
            $join->on('reviews.user_id', '=', 'users.id');
        })
        ->whereNotNull('reviews.id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'reviews.movie_series_id');
            $join->on('rateds.user_id', '=', 'reviews.user_id')
            ->where('reviews.mode', '=', 1);
        })
        ->leftjoin('movies', function ($join) {
            $join->on('movies.id', '=', 'reviews.movie_series_id')
            ->where('reviews.mode', '=', 1);
        })
        ->leftjoin('series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'reviews.movie_series_id');
            $join->on('series_rateds.user_id', '=', 'reviews.user_id')
            ->where('reviews.mode', '=', 3);
        })
        ->leftjoin('series', function ($join) {
            $join->on('series.id', '=', 'reviews.movie_series_id')
            ->where('reviews.mode', '=', 3);
        })
        ->groupBy('reviews.id');

        if(Auth::check()){
            $reviews = $reviews
            ->select(
            	'users.name as name',
            	'users.id as user_id',
                'reviews.id as review_id',
                'reviews.review as content',
                'reviews.mode as mode',
                'reviews.movie_series_id as movie_series_id',
                'reviews.season_number',
                'reviews.episode_number',
                DB::raw('IF(movies.id>0, movies.'.Auth::User()->lang.'_title, series.'.Auth::User()->lang.'_name) as movie_title'),
                DB::raw('IF(movies.id>0, rateds.rate, series_rateds.rate) as rate'),
                DB::raw('IF(movies.id>0, movies.original_title, series.original_name) as original_title'),
                DB::raw('IF(movies.id>0, movies.release_date, series.first_air_date) as release_date'),
                DB::raw('COUNT(review_likes.id) as count'),
                DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
            );
        }else{
            $reviews = $reviews
            ->select(
            	'users.name as name',
            	'users.id as user_id',
                'reviews.id as review_id',
                'reviews.review as content',
                'reviews.mode as mode',
                'reviews.movie_series_id as movie_series_id',
                'reviews.season_number',
                'reviews.episode_number',
                DB::raw('IF(movies.id>0, movies.'.App::getlocale().'_title, series.'.App::getlocale().'_name) as movie_title'),
                DB::raw('IF(movies.id>0, rateds.rate, series_rateds.rate) as rate'),
                DB::raw('IF(movies.id>0, movies.original_title, series.original_name) as original_title'),
                DB::raw('IF(movies.id>0, movies.release_date, series.first_air_date) as release_date'),
                DB::raw('COUNT(review_likes.id) as count')
            );
        }

        if($mode == 'most liked'){
            $reviews = $reviews
            ->whereNotNull('review_likes.id')
            ->orderBy('count', 'desc');
        }else if($mode == 'newest'){
            $reviews = $reviews
            ->orderBy('reviews.updated_at', 'desc');
        }

        if($f_following == 'following'){
            $reviews = $reviews
            ->leftjoin('follows as f2', function ($join) {
                $join->on('reviews.user_id', '=', 'f2.object_id')
                ->where('f2.subject_id', '=', Auth::id())
                ->where('f2.is_deleted', '=', 0);
            })
            ->whereNotNull('f2.id');
        }

        return $reviews->paginate($pagination);
    }



	public function main($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

        if(Auth::check()){
            $image_quality = Auth::User()->image_quality;
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
            
            $is_following1 = DB::table('follows')
            ->where('follows.subject_id', '=', Auth::id())
            ->leftjoin('rateds', function ($join) {
                $join->on('rateds.user_id', '=', 'follows.object_id');
            })
            ->where('rateds.rate', '=', 5)
            ->count();

            $is_following2 = DB::table('follows')
            ->where('follows.subject_id', '=', Auth::id())
            ->leftjoin('series_rateds', function ($join) {
                $join->on('series_rateds.user_id', '=', 'follows.object_id');
            })
            ->where('series_rateds.rate', '=', 5)
            ->count();
        }else{
            $image_quality = 1;
            $target = '_self';
            $watched_movie_number = null;
            $is_following1 = 0;
            $is_following2 = 0;
        }
        
        $movies = $this->get_legendary_garbage_movies(5, $is_following1>0?'following':'all', 'newest');
        $series = $this->get_airing_series('watch later');
        $f_watch_later = 'watch later';
        if($series->count()==0){
            $series = $this->get_airing_series('all');
            $f_watch_later = 'all';
        }
        $people = $this->get_popular_people('born today');
        $users = $this->get_popular_users('list', 'all');
        $reviews = $this->get_popular_reviews('newest', 'all');
        $listes = $this->get_popular_lists('newest', 'all');
        
        $amazon_variables_general = amazon_variables_general();
        $amazon_variables_general_2 = amazon_variables_general();
        $amazon_variables_general_3 = amazon_variables_general();
        $amazon_variables_general_4 = amazon_variables_general();
        $amazon_variables_general_5 = amazon_variables_general();

		return view('main', compact('image_quality', 'target', 'watched_movie_number', 'is_following1', 'is_following2', 'f_watch_later', 'amazon_variables_general', 'amazon_variables_general_2', 'amazon_variables_general_3', 'amazon_variables_general_4', 'amazon_variables_general_5'))
            ->with('movies', $movies)
            ->with('series', $series)
            ->with('people', $people)
            ->with('users', $users)
            ->with('reviews', $reviews)
            ->with('listes', $listes);
	}
}
