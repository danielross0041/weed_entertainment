<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestAttributes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;
use App\Models\attributes;
use App\Models\role_assign;

use App\Models\production_schedule;
use App\Models\comments;
use App\Models\replies;
use App\Models\videos;

use Illuminate\Support\Str;
use Session;
use Helper;

class GenericController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $user = Helper::curren_user();

        // $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        // $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        
        // View()->share('att_tag',$att_tag);
        // View()->share('role_assign',$role_assign);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function roles()
    {
        $user = Auth::user();
        if ($user->role_id != 1) {
            return redirect()->back()->with('error', "No Link found");
        }
        $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        $attributes = attributes::where('is_active' ,1)->get();
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        
        return view('roles/roles')->with(compact('attributes','att_tag','role_assign'));
    }
    
    public function generic_submit(RequestAttributes $request)
    {
        // $user = User::find(Auth::user()->id);
        // $columns  = \Schema::getColumnListing("attributes");
        // $ignore = ['id' , 'is_active' ,'is_deleted' , 'created_at' , 'updated_at' ,'deleted_at'];
        //$push_in = array_diff($columns, $ignore);

        $token_ignore = ['_token' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        
        try{
            attributes::insert($post_feilds);
            return redirect()->back()->with('message', 'Information updated successfully');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Error will saving record');
        }
    }

    public function role_assign_modal()
    {
        $user = Auth::user();
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$_POST['role_id'])->orderBy('id','desc')->first();
        $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        $body = "";
        if ($att_tag) {
            $route = route('roleassign_submit');
            $body .= "<input type='hidden' name='role_id' id='fetch-role-id' value='".$_POST['role_id']."'>";
            if ($role_assign && $role_assign->assignee!='N;') {
                $checker = unserialize($role_assign->assignee);
                $body .= "<input type='hidden' name='record_id' value='".$role_assign->id."'>";
            }else{
                $checker = [];
            }
            foreach($att_tag as $key => $role){
                $body .= "<tr><td>".ucwords($role->attribute)."</td><td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck1".$key."' ";
                                   if(in_array($role->attribute."_1", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_1'>
                                  <label class='custom-control-label' for='customCheck1".$key."'>1</label></div></td>
                            
                            <td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck2".$key."' ";
                                   if(in_array($role->attribute."_2", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_2'>
                                  <label class='custom-control-label' for='customCheck2".$key."'>2</label></div></td>

                            <td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck3".$key."' ";
                                   if(in_array($role->attribute."_3", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_3'>
                                  <label class='custom-control-label' for='customCheck3".$key."'>3</label></div></td>

                            <td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck4".$key."' ";
                                   if(in_array($role->attribute."_4", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_4'>
                                  <label class='custom-control-label' for='customCheck4".$key."'>4</label></div></td></tr>";    
            }
        }

        $bod['body'] = $body;
        $response = json_encode($bod);
        return $response;
    }

    public function roleassign_submit(Request $request)
    {
        if (isset($request->record_id) && $request->record_id != 0) {
            $role_assign = role_assign::where('is_active' ,1)->where("id" ,$request->record_id)->first();
        }else{
            $role_assign = new role_assign;
            $role_assign->role_id = $request->role_id;    
        }
        
        $role_assign->assignee = serialize($request->assignee);
        $role_assign->save();
        return redirect()->back()->with('message', 'Role has been assigned successfully');
    }

    public function listing($slug='')
    {
        if ($slug == 'contact') {
            $slug = "contact_details";
        }
        $user = Auth::user();
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        if ($role_assign) {
            $validator = Helper::check_rights($slug);
            if (is_null($validator)) {
                return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
            }
        }else{
            return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
        }
        
        $form = null;
        $table = null;
        $eloquent = '';
        if($slug == "roles"){
            $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();

            $attributes = attributes::where('is_active' ,1)->where('attribute' , $slug)->get();
            $is_hide = 0;
        }else{
            $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
            $attributes = attributes::where('is_active' ,1)->where('attribute' , $slug)->get();
            $get_eloquent = attributes::where('is_active' ,1)->where('attribute' , $slug)->first();
            $eloquent = ($get_eloquent->model != '')?$get_eloquent->model:'';
            $is_hide = 1;
            if ($eloquent != '') {
                $form = $this->generated_form($slug);
                $table = $this->generated_table($slug);
            }

        }
        return view('roles/crud')->with(compact('attributes','att_tag','role_assign','validator','slug','is_hide','eloquent','form','table'));
    }
    
    private function generated_form($slug = '')
    {
        $body = '';

        if ($slug == 'testimonials') {
            $route_url = route('crud_generator', $slug);
            $body = '<form class="" id="generic-form" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Name:</label>
                                <div class="d-flex">
                                    <input id="name" placeholder="Name" name="name" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="role-label">
                            <div class="form-group end-date">
                                <label for="end-date" class="">Description:</label>
                                <div class="d-flex">
                                    <textarea id="description" required name="desc" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'comment-uploader') {
            $route_url = route('vedio_api');
            $body = '<form class="" id="generic-form" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Please enter Video ID:</label>
                                <div class="d-flex">
                                    <input id="video_id" placeholder="Video ID" name="video_id" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'fileUploader') {
            $route_url = route('file_generator');
            $body = '<form class="" id="generic-form" enctype="multipart/form-data" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-6 col-sm-6 col-6 im" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">File:</label>
                                <div class="d-flex">
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } else{
            return $body;
        }
    }

    private function generated_table($slug='')
    {
        

        $body = '';
        if ($slug == "testimonials") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Description</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->name.'</td> 
                                          <td>'.$val->desc.'</td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'" data-name= "'.$val->name.'" data-desc= "'.$val->desc.'" >Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Description</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#name").val($(this).data("name"))
                                                $("#record_id").val($(this).data("edit_id"))
                                                var texta = $(this).data("desc");
                                                CKEDITOR.instances.description.setData(texta);
                                                $("#addevent").modal("show")
                                            })';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "comment-uploader") {
            $data = 'App\Models\videos';
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->orderBy('id', 'DESC')->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Video ID</th>
                                          <th>Description</th>
                                          <th>Title</th>
                                          <th>Thumbnail</th>
                                          <th>Creation Date</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->video_id.'</td> 
                                          <td>'.$val->description.'</td>
                                          <td>'.$val->title.'</td>
                                          <td><img style="width:80px;height:80px;" src="'.$val->thumbnail.'"></td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Video ID</th>
                                          <th>Description</th>
                                          <th>Title</th>
                                          <th>Thumbnail</th>
                                          <th>Creation Date</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "fileUploader") {
            $loop = production_schedule::where("is_active" ,1)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Batch</th>
                                          <th>Product</th>
                                          <th>MRP</th>
                                          <th>Quantity</th>
                                          <th>size</th>
                                          <th>Creation Date</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->batch.'</td>
                                          <td>'.$val->product.'</td>
                                          <td>'.$val->mrp.'</td>
                                          <td>'.$val->quantity.'</td>
                                          <td>'.$val->size.'</td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Batch</th>
                                          <th>Product</th>
                                          <th>MRP</th>
                                          <th>Quantity</th>
                                          <th>size</th>
                                          <th>Creation Date</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } else{
            return $body;
        }
    }

    public function report_user($slug)
    {
        $user = Auth::user();
        
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        if ($role_assign) {
            $validator = Helper::check_rights($slug);
            if (is_null($validator)) {
                return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
            }
        }else{
            return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
        }
        
        $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        $attributes = attributes::where('is_active' ,1)->where('attribute' , $slug)->get();
        return view('reports/report_generic_user')->with(compact('attributes','att_tag','role_assign','validator','slug'));
    }

    public function custom_report()
    {
        $status['status'] = 0;
        if (isset($_POST['role_id'])) {
            $attributes = attributes::find($_POST['role_id']);
            if ($attributes->attribute == "departments") {
                $status['status'] = 1;
                $status['redirect'] = route('custom_report_user' ,[$attributes->attribute , str::slug($attributes->name)]);

                return json_encode($status);
            }elseif ($attributes->attribute == "designations") {
                $status['status'] = 1;
                $status['redirect'] = route('custom_report_user' ,[$attributes->attribute , str::slug($attributes->name)]);
                return json_encode($status);
            }elseif ($attributes->attribute == "roles") {
                $status['status'] = 1;
                $status['redirect'] = route('custom_report_user' ,[$attributes->attribute , str::slug($attributes->role)]);
                return json_encode($status);
            }else{
                $status['status'] = 0;
                return json_encode($status);
            }
        }else{
            $status['status'] = 0;
            return json_encode($status);
        }
    }

    public function custom_report_user($slug='',$slug2='')
    {
        $attributes = attributes::where("attribute" , $slug)->first();
        $designation = attributes::where("is_active" , 1)->get();
        $project_id = Session::get("project_id");
        if ($attributes) {

            if ($attributes->attribute == "departments") {
                $all_user = User::where("is_active" , 1)->where("department" , $attributes->id)->get();
                return view('reports/custom-user-report')->with(compact('attributes','all_user','slug','designation'));
            }elseif ($attributes->attribute == "designations") {
                $slug2 = ucwords(str_replace('-', ' ', $slug2));
                $attributes = attributes::where("attribute" , $slug)->where("name" , "LIKE" , $slug2)->first();
                $all_user = User::where("is_active" , 1)->where("designation" , $attributes->id)->get();
                return view('reports/custom-user-report')->with(compact('attributes','all_user','slug','designation'));
            }elseif ($attributes->attribute == "roles") {
                $slug2 = ucwords(str_replace('-', ' ', $slug2)); 
                $attributes = attributes::where("attribute" , $slug)->where("role" , "LIKE" , $slug2)->first();
                if (!$attributes) {
                    return redirect()->back()->with('error', "Didn't find any records.!");
                }
                $all_user = User::where("is_active" , 1)->where("role_id" , $attributes->id)->get();
                return view('reports/custom-user-report')->with(compact('attributes','all_user','slug','designation'));
            }else{
                return redirect()->back()->with('error', "Didn't find any records.!");
            }
        }else{
            return redirect()->back()->with('error', "Didn't find any records..");
        }
    }
    public function sale_generator(Request $request){
        $token_ignore = ['_token' => '' ];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        $data = 'App\Models\car_sale';
        $car_feilds['is_sale'] = 1;
        // dd($post_feilds);
        try {
            $check = $data::where('is_active',1)->where('is_deleted',0)->where('product_id',$_POST['product_id'])->first();

            if ($check) {
                $create = $data::where("id" ,$check->id)->update($post_feilds);
                $product_sale = car_details::where("id" ,$_POST['product_id'])->update($car_feilds);
                $msg = "Record has been updated";
            } else{
                $create = $data::create($post_feilds);
                $product_sale = car_details::where("id" ,$_POST['product_id'])->update($car_feilds);
                $msg = "Record has been created";
            }
          return redirect()->back()->with('message', $msg);
        } catch(Exception $e) {
          $error = $e->getMessage();
          return redirect()->back()->with('error', "Error Code: ".$error);
        }
    }
    public function crud_generator($slug='' , Request $request)
    {
        $token_ignore = ['_token' => '' , 'record_id' => '' , 'image' => '', 'finish_caliper' => '' , 'note' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        // dd($post_feilds);
        $data = 'App\Models\\'.$slug;
        if (isset($_POST['name']) && $_POST['name'] != '') {
            $s = $_POST['name'];
            $s = str_replace(' ', '', $s);
            $s = strtolower($s);
            $post_feilds['slug'] = $s;
        }
        $extension=array("jpeg","jpg","png");
        if (isset($request->image)) {
            $file = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            if(in_array($ext,$extension)) {
                $file_name = $request->image->getClientOriginalName();
                $file_name = substr($file_name, 0, strpos($file_name, "."));
                $name = "uploads/product/" .$file_name."_".time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path().'/uploads/product/';
                $share = $request->image->move($destinationPath,$name);
                $post_feilds['image'] = $name;
            } else{
                $msg = "This File type is not Supported!";
                return redirect()->back()->with('error', "Error Code: ".$msg);
            }
        }
        try {
            if (isset($_POST['record_id']) && $_POST['record_id'] != '') {
                $create = $data::where("id" , $_POST['record_id'])->update($post_feilds);
                $msg = "Record has been updated";
            } else{
                if ($slug == 'car_details') {
                    $check_record = car_details::where('is_active',1)->where('slug',$slug)->first();
                    if ($check_record) {
                        $msg = "This Product already exists";
                        return redirect()->back()->with('error',$msg);
                    }
                }
                $create = $data::create($post_feilds);
                $msg = "Record has been created";
            }
          return redirect()->back()->with('message', $msg);
        } catch(Exception $e) {
          $error = $e->getMessage();
          return redirect()->back()->with('error', "Error Code: ".$error);
        }
    }
    public function vedio_api(Request $request)
    {
        try{
            $video_feilds = array();
            $checker = videos::where('is_active',1)->where('video_id',$request->video_id)->first();
            if ($checker) {
                return redirect()->back()->with('error', "Comments from this Video have already been uploaded");
            }

            $video = new \Google_Client();
            $video->setApplicationName('API code samples');
            $video->setDeveloperKey('AIzaSyCW0tdkzgAF2eLC4kZtwhXHKjmAdwYTk38');

            // Define service object for making API requests.
            $video_service = new \Google_Service_YouTube($video);

            $video_queryParams = [
                'id' => $request->video_id
            ];

            $video_response = $video_service->videos->listVideos('snippet,contentDetails,statistics', $video_queryParams);
            $feilds = $video_response->items[0]->snippet;
            // dd($feilds->thumbnails);
            if ($feilds->thumbnails->maxres) {
                $thumbnails = $feilds->thumbnails->maxres->url;
            } elseif ($feilds->thumbnails->standard) {
                $thumbnails = $feilds->thumbnails->standard->url;
            } elseif ($feilds->thumbnails->high) {
                $thumbnails = $feilds->thumbnails->high->url;
            } elseif ($feilds->thumbnails->medium) {
                $thumbnails = $feilds->thumbnails->medium->url;
            } else{
                $thumbnails = $feilds->thumbnails->default->url;
            }

            $video_feilds['video_id'] = $request->video_id;
            $video_feilds['description'] = $feilds->description;
            $video_feilds['title'] = $feilds->title;
            $video_feilds['thumbnail'] = $thumbnails;
            $video_create = videos::create($video_feilds);

            $comment_feilds = array();
            $reply_feilds = array();
            
            

            $client = new \Google_Client();
            $client->setApplicationName('API code samples');
            $client->setDeveloperKey('AIzaSyCW0tdkzgAF2eLC4kZtwhXHKjmAdwYTk38');

            $service = new \Google_Service_YouTube($client);

            $queryParams = [
                 'maxResults' => 1000,
                'order' => 'relevance',
                'videoId' => $request->video_id
            ];

            $response = $service->commentThreads->listCommentThreads('snippet,replies', $queryParams);

            // dd($response);
            foreach ($response as $key => $value) {
                $comment_feilds['video_id'] = $video_create->id;
                $comment_feilds['author'] = $value->snippet->topLevelComment->snippet->authorDisplayName;
                $comment_feilds['author_id'] = $value->snippet->topLevelComment->snippet->authorChannelUrl;
                $comment_feilds['comment'] = $value->snippet->topLevelComment->snippet->textDisplay;
                $comment_feilds['image'] = $value->snippet->topLevelComment->snippet->authorProfileImageUrl;
                $comments = comments::create($comment_feilds);
                if ($comments) {
                    if (isset($value->replies->comments)) {
                        foreach ($value->replies->comments as $i => $reply) {
                            $reply_feilds['comment_id'] = $comments->id;
                            $reply_feilds['author'] = $reply->snippet->authorDisplayName;
                            $reply_feilds['author_id'] = $reply->snippet->authorChannelUrl;
                            $reply_feilds['reply'] = $reply->snippet->textDisplay;
                            $reply_feilds['image'] = $reply->snippet->authorProfileImageUrl;
                            $replies = replies::create($reply_feilds);
                        }
                    }
                } else{
                    return redirect()->back()->with('error', "Comments from this Video could not be uploaded");
                }
            }
            $msg = "Comments has been uploaded";
            return redirect()->back()->with('message', $msg);
        } catch(Exception $e) {
            $error = $e->getMessage();
            return redirect()->back()->with('error', "Error Code: ".$error);
        }
        
    }
    public function delete_record(Request $request)
    {
        $token_ignore = ['_token' => '' , 'id' => '' , 'model' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        $data = $_POST['model'];
        try{
            $update = $data::where("id" , $_POST['id'])->update($post_feilds);
            $status['message'] = "Record has been deleted";
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
    }
    
}