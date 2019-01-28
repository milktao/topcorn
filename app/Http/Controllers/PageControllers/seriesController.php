<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class seriesController extends Controller
{
    public function series($id, $lang = '', $secondary_lang='')
    {
    	$image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
        }else{
            $target = '_self';
        }

        $id_dash_name=$id;
        $id=explode("-", $id)[0];
        if(!is_numeric($id)){
            return redirect('/not-found');
        }else{
            $series = DB::table('series')
            ->where('series.id', '=', $id);
            if($series->count() > 0){
                $series = $series->first();
                $series_name = $series->original_name;
                $series_en_name = $series->en_name != $series_name ? $series->en_name : '';
                $series_tr_name = $series->tr_name != $series_name ? ($series->tr_name != $series_en_name ? $series->tr_name :'') : '';
                $series_hu_name = $series->hu_name != $series_name ? ($series->hu_name != $series_en_name ? ($series->hu_name != $series_tr_name ? $series->hu_name :'') :'') : '';
                $series_year = substr($series->release_date,0 ,4);
                $poster_path = $series->en_poster_path;
            }else{
                $series_name = '';
                $series_en_name = '';
                $series_tr_name = '';
                $series_hu_name = '';
                $series_year = '';
                $poster_path = '';
            }
        }

    	return view('series', compact('id', 'id_dash_name', 'image_quality', 'target', 'series_name', 'series_en_name', 'series_tr_name', 'series_hu_name', 'series_year', 'series_path'));
    }
}
