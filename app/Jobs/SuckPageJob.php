<?php

namespace App\Jobs;

use App\Jobs\SuckMovieJob;
use App\Jobs\SuckSeriesJob;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\firstOrCreate;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SuckPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page;
    protected $isPopular;
    protected $isMovie;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page, $isPopular, $isMovie)
    {
        $this->page = $page;
        $this->isPopular = $isPopular;
        $this->isMovie = $isMovie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->isMovie){
            if($this->isPopular){
                $movies = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key='.config('constants.api_key').'&language=en-US&page='.$this->page), true)['results'];
            }else{
                $movies = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/top_rated?api_key='.config('constants.api_key').'&language=en-US&page='.$this->page), true)['results'];   
            }
            for ($j=0; $j < count($movies) ; $j++) {
                if($movies[$j]['vote_average'] > config('constants.suck_page.min_vote_average') && $movies[$j]['vote_count'] > config('constants.suck_page.min_vote_count')){
                    SuckMovieJob::dispatch($movies[$j]['id'], false)->onQueue("low");
                }
            }
        }else{
            if($this->isPopular){
                $series = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/popular?api_key='.config('constants.api_key').'&language=en-US&page='.$this->page), true)['results'];
            }else{
                $series = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/top_rated?api_key='.config('constants.api_key').'&language=en-US&page='.$this->page), true)['results'];   
            }
            for ($j=0; $j < count($series) ; $j++) {
                if($series[$j]['vote_average'] > config('constants.suck_page.min_vote_average') && $series[$j]['vote_count'] > config('constants.suck_page.min_vote_count')){
                    SuckSeriesJob::dispatch($series[$j]['id'], false)->onQueue("low");
                }
            }
        }
    }
}
