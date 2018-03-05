<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class recommendationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function recommendations($user = '')
    {
        if($user != ''){
            $with_user = User::where(['id' => $user])->first();
            if($with_user){
                Session::flash('with_user_id', $user);
                Session::flash('with_user_name', $with_user->name);
            }
            return redirect('/recommendations');
        }

        $image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

        return view('recommendations', compact('image_quality', 'target', 'watched_movie_number'));
    }

    


    public function get_top_rateds($tab, Request $request)
    {
        $start = microtime(true);

        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }

        $subq = DB::table('rateds')
        ->whereIn('rateds.user_id', $request->f_users)
        ->where('rateds.rate', '>', 0)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
        ->join('movies', 'movies.id', '=', 'recommendations.this_id')
        ->select(
            'movies.id',
            DB::raw('sum((rateds.rate-3)*recommendations.is_similar) DIV '.count($request->f_users).' as point'),
            DB::raw('COUNT(movies.id) as count'),
            DB::raw('sum(rateds.rate)*20 DIV COUNT(movies.id) as percent'),
            DB::raw('sum(rateds.rate*recommendations.is_similar)*4 DIV COUNT(movies.id) as p2')
        )
        ->groupBy('movies.id');

        $qqSql = $subq->toSql();

    /////////////////////////////////////////////////////////

        $subq_2 = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') as ss'),
            function($join) use ($subq) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq->getBindings());  
            }
        )
        ->rightjoin('movies as m2', 'm2.id', '=', 'movies.id')
        ->select(
            'm2.id',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2'
        )
        ->where('m2.vote_count', '>', $request->f_vote)
        ->where('m2.vote_average', '>', config('constants.suck_page.min_vote_average'));


        if($request->f_genre != [])
        {
            $subq_2 = $subq_2->join('genres', 'genres.movie_id', '=', 'm2.id')
            ->whereIn('genre_id', $request->f_genre)
            ->groupBy('m2.id')
            ->havingRaw('COUNT(m2.id)='.count($request->f_genre));
        };

        if($request->f_lang != [])
        {
            $subq_2 = $subq_2->whereIn('m2.original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $subq_2 = $subq_2->where('m2.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2018)
        {
            $subq_2 = $subq_2->where('m2.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        $qqSql_2 = $subq_2->toSql();

    /////////////////////////////////////////////////////////

        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql_2. ') AS ss'),
            function($join) use ($subq_2) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq_2->getBindings());  
            }
        )
        ->leftjoin('rateds', function ($join) use ($request) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->whereIn('rateds.user_id', $request->f_users);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('bans', function ($join) use ($request) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', $request->f_users);
        })
        ->select(
            'movies.id',
            'movies.'.$hover_title.' as original_title',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id')
        ->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0 AND sum(IF(bans.id IS NULL, 0, 1)) = 0');

        if($tab=='popular'){
            $return_val = $return_val->orderBy('movies.popularity', 'desc');
        }else{
            $return_val = $return_val->orderBy('movies.vote_average', 'desc')
            ->orderBy('movies.vote_count', 'desc');
        }


        return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];

        /*$start = microtime(true);
         
        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }
        
        $return_val = DB::table('movies')
        ->where('vote_count', '>', Auth::User()->min_vote_count*5)
        ->where('vote_average', '>', config('constants.suck_page.min_vote_average'))
        ->leftjoin('rateds', function ($join) use ($request) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->whereIn('rateds.user_id', $request->f_users);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        //->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join) use ($request) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', $request->f_users);
        })
        ->where('bans.id', '=', null)
        ->select(
            'movies.id as id',
            'movies.'.$hover_title.' as original_title',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id')
        ->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0');

        if($tab=='popular'){
            $return_val = $return_val->orderBy('popularity', 'desc');
        }else{
            $return_val = $return_val->orderBy('vote_average', 'desc');
        }

        if($request->f_genre != []){
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'movies.id')
            ->whereIn('genre_id', $request->f_genre)
            ->havingRaw('COUNT(*)='.count($request->f_genre));
        }

        if($request->f_lang != [])
        {
            $return_val = $return_val->whereIn('original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $return_val = $return_val->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2018)
        {
            $return_val = $return_val->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];*/
    }




    public function get_pemosu(Request $request)
    {
        $start = microtime(true);

        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }

        $subq = DB::table('rateds')
        ->whereIn('rateds.user_id', $request->f_users)
        ->where('rateds.rate', '>', 0)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
        ->join('movies', 'movies.id', '=', 'recommendations.this_id')
        ->leftjoin('rateds as r2', function ($join) use ($request) {
            $join->on('r2.movie_id', '=', 'movies.id')
            ->whereIn('r2.user_id', $request->f_users);
        })
        ->select(
            'recommendations.this_id as id',
            DB::raw('sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) DIV '.count($request->f_users).' AS point'),
            DB::raw('COUNT(recommendations.this_id) as count'),
            DB::raw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) as percent'),
            DB::raw('sum(4*recommendations.is_similar) as p2'),
            'r2.id as rated_id',
            'r2.rate as rate_code'
        )
        ->groupBy('movies.id')
        ->havingRaw('sum((rateds.rate-3)*recommendations.is_similar) DIV '.count($request->f_users).' > 7 AND sum(rateds.rate-1)*25 DIV COUNT(movies.id) > 70 AND sum(IF(r2.id IS NULL OR r2.rate = 0, 0, 1)) = 0');

        if($request->f_lang != [])
        {
            $subq = $subq->whereIn('original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $subq = $subq->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2018)
        {
            $subq = $subq->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        $qqSql = $subq->toSql();

        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq->getBindings());  
            }
        )
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('bans', function ($join) use ($request) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', $request->f_users);
        })
        ->where('bans.id', '=', null)
        ->select(
            'movies.'.$hover_title.' as original_title',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'ss.id',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'ss.rated_id',
            'ss.rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->where('movies.vote_count', '>', $request->f_vote);

        if($request->f_sort == 'point'){
            $return_val = $return_val->orderBy('point', 'desc')
            ->orderBy('percent', 'desc')
            ->orderBy('vote_average', 'desc');
        }else if($request->f_sort == 'percent'){
            $return_val = $return_val->orderBy('percent', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('vote_average', 'desc');
        }else if($request->f_sort == 'top_rated'){
            $return_val = $return_val->orderBy('vote_average', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('percent', 'desc');
        }else if($request->f_sort == 'most_popular'){
            $return_val = $return_val->orderBy('popularity', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('percent', 'desc');
        }

        if($request->f_genre != [])
        {
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'ss.id')
            ->whereIn('genre_id', $request->f_genre)
            ->groupBy('movies.id')
            ->havingRaw('COUNT(movies.id)='.count($request->f_genre));
        }
        

        return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];
    }
}
