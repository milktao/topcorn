<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Review::updateOrCreate(
            array('user_id' => Auth::id(), 'movie_series_id' => $request->movie_series_id),
            array('review' => strip_tags($request->review), 'mode' => $request->mode, 'lang' => Auth::User()->lang)
        );

        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $request->movie_series_id)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')
        ->groupBy('reviews.id')
        ->select(
            'reviews.tmdb_author_name as author',
            'reviews.review as content',
            'reviews.tmdb_review_id as id',
            'reviews.lang as url',
            'reviews.id as review_id',
            'users.name as name',
            'users.id as user_id',
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');

        return Response([
            'data' => $review->paginate(25),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($movie_series_id)
    {
        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $movie_series_id)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')
        ->groupBy('reviews.id');

        if(Auth::check()){
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                DB::raw('COUNT(review_likes.id) as count'),
                DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
            )
            ->orderBy('count', 'desc')
            ->orderBy('is_mine', 'desc');
        }else{
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                DB::raw('COUNT(review_likes.id) as count')
            )
            ->orderBy('count', 'desc');
        }

        return $review->paginate(25);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($movie_series_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy_review($movie_series_id, $mode)
    {
        $will_be_deleted = Review::where('movie_series_id', $movie_series_id)
        ->where('mode', $mode)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }

        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $movie_series_id)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')
        ->groupBy('reviews.id')
        ->select(
            'reviews.tmdb_author_name as author',
            'reviews.review as content',
            'reviews.tmdb_review_id as id',
            'reviews.lang as url',
            'reviews.id as review_id',
            'users.name as name',
            'users.id as user_id',
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');
        
        return Response([
            'data' => $review->paginate(25),
        ], Response::HTTP_CREATED);
    }
}
