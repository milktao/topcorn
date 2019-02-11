<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\CustomNotification;
use App\Model\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomNotificationController extends Controller
{    
	public function create_notification($id = 'new')
    {
    	if(Auth::id()!=7) return 'You are unauthorized';

    	if($id == 'new'){
            $liste = '[]';
		}else{
            $temp = DB::table('custom_notifications')
            ->where('custom_notifications.id', '=', $id);

            if($temp->count()>0){
                $liste = $temp
                ->get()
                ->toArray();
            }else{
                return 'nothing found';
            }
        }

        return view('createnotification', compact('id', 'liste'));
    }




    public function post_create_notification(Request $request)
    {
    	if(Auth::id()!=7) return 'You are unauthorized';

    	if($request->mode != 2){
	        $liste = CustomNotification::updateOrCreate(
	            ['id' => $request->list_id],
	            ['mode' => $request->mode,
	            'icon' => $request->icon,
	            'en_notification' => $request->en_notification,
	            'tr_notification' => $request->tr_notification,
	            'hu_notification' => $request->hu_notification,]
	        );
	        $liste_id = $liste->id;

	        if($request->mode == 1){
	        	Notification::updateOrCreate(
	        	    ['mode' => 2, 'user_id' => 7, 'multi_id' => $liste->id],
	        	    ['is_seen' => 0]
	        	);
	        }else if($request->mode == 3){
	        	foreach(User::all() as $user) {
		        	Notification::updateOrCreate(
		        	    ['mode' => 2, 'user_id' => $user->id, 'multi_id' => $liste->id],
		        	    ['is_seen' => 0]
		        	);
	        	}
	        }
	    }else{
	    	$will_be_deleted = CustomNotification::where('id', $request->list_id)->first();
	    	
	    	if($will_be_deleted){
	    	    $will_be_deleted->delete();
	    	}

	    	$will_be_deleted = Notification::where('multi_id', $request->list_id)
	    	->where('mode', '=', '2')
	    	->all();
	    	
	    	if($will_be_deleted){
	    	    $will_be_deleted->delete();
	    	}

	    	$liste_id = 'new';
	    }

        $request->session()->flash('status', __('general.list_updated'));


        return redirect('/create_notification/'.$liste_id);
    } 
}
