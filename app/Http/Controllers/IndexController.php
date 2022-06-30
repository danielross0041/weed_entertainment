<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\attributes;
use App\Models\company;
use App\Models\car_details;
use App\Models\category;
use App\Models\subcategory;
use App\Models\accessories;
use App\Models\brand;
use App\Models\contact_details;
use App\Models\comments;
use App\Models\replies;
use App\Models\videos;


use Illuminate\Support\Str;
use App\Mail\mailer;
use Session;
use Helper;
use Mail;
use Carbon\Carbon;
use \Crypt;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $videos = videos::where('is_active',1)->get()->toArray();
        // dd($videos);
        $videos = array_chunk($videos, 9);
        return view('web.index')->with(compact('videos'));
    }
    public function video($id){
        // dd($id);
        $video = videos::where('is_active',1)->where('id',$id)->first();
        $comments = comments::where('is_active',1)->where('video_id',$id)->get();
        // dd($comments,$video);
        return view('web.video')->with(compact('comments','video'));
    }
    public function qr_code()
    {
        return view('web.qr_code');
    }
    
    
    public function account(){
        
        if (Auth::check()) {
            
            return redirect()->route('dashboard');
        }
        $title = 'Dan TerryBerry - Login';
        return view('auth.login')->with(compact('title'));
    }

}
