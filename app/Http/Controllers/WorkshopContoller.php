<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Workshop;
use App\Currency;
use Image;
use App\Workshopinclude;
use App\Workwhatlearn;
use App\Cart;
use Auth;
use Session;


class WorkshopContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workshop = Workshop::all();
           
        return view('admin.workshop.index',compact("workshop"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workshop = Workshop::all();
        $money = Currency::first();
        $amount = Currency::orderby('id','desc')->first();
        return view('admin.workshop.insert', compact('money','amount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[            
            'title' => 'required',
            'short_detail' => 'required',
            'detail' => 'required',
            'video' => 'mimes:mp4,avi,wmv',
            'slug' => 'required|unique:courses,slug',
        ]);

        $input = $request->all();

        $data = Workshop::create($input); 

        if(isset($request->type))
        {
          $data->type = "1";
        }
        else
        {
          $data->type = "0";
        }


        if($file = $request->file('preview_image')) 
        {        
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/workshop/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $data->preview_image = $image;
          
        }


        if(isset($request->preview_type))
        {
          $data->preview_type = "video";
        }
        else
        {
          $data->preview_type = "url";
        }

                    
        if(!isset($request->preview_type))
        {
            $data->url = $request->url;
        }
        else if($request->preview_type )
        {
            if($file = $request->file('video'))
            {
                
              $filename = time().$file->getClientOriginalName();
              $file->move('video/preview',$filename);
              $data->video = $filename;
            }
        }
        

        $data->save();

        return redirect('workshop');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cor = Workshop::find($id);             
        return view('admin.course.editcor',compact('cor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'video' => 'mimes:mp4,avi,wmv'
  
          ]);
  
          $course = Workshop::findOrFail($id);
          $input = $request->all();
           
  
          if(isset($request->type))
          {
            $input['type'] = "1";
          }
          else
          {
            $input['type'] = "0";
          }
  
          
          if ($file = $request->file('image')) {
            
            if($course->preview_image != null) {
              $content = @file_get_contents(public_path().'/images/workshop/'.$course->preview_image);
              if ($content) {
                unlink(public_path().'/images/workshop/'.$course->preview_image);
              }
            }
  
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/workshop/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);
  
            $input['preview_image'] = $image;
            
          }
  
  
          if(isset($request->preview_type))
          {
            $input['preview_type'] = "video";
          }
          else
          {
            $input['preview_type'] = "url";
          }
  
          
          if(!isset($request->preview_type))
          {
              $course->url = $request->video_url;
              $course->video = null;
              
          }
          else if($request->preview_type )
          {
              if($file = $request->file('video'))
              {
                if($course->video != "")
                {
                  $content = @file_get_contents(public_path().'/video/preview/'.$course->video);
                  if ($content) {
                    unlink(public_path().'/video/preview/'.$course->video);
                  }
                }
                
                $filename = time().$file->getClientOriginalName();
                $file->move('video/preview',$filename);
                $input['video'] = $filename;
                $course->url = null;
  
              }
          }
  
         
    Cart::where('workshop_id', $id)
         ->update([
             'price' => $request->price,
             'offer_price' => $request->discount_price,
          ]);

  
  
          $course->update($input);
  
          return redirect('workshop');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Workshop::find($id);
        
        if ($course->preview_image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/workshop/'.$course->preview_image);

            if($image_file)
            {
                unlink(public_path().'/images/workshop/'.$course->preview_image);
            }
        }
        if ($course->video != null)
        {
                
            $video_file = @file_get_contents(public_path().'/video/preview/'.$course->video);

            if($video_file != null)
            {
                unlink(public_path().'/video/preview/'.$course->video);
            }
        }

        $value = $course->delete();
        return back()->with('delete','Course is Deleted');
    }

    public function showCourse($id,Request $request){
        $course = Workshop::all();
      
        $cor = Workshop::findOrFail($id);
       
        $workshopinclude = Workshopinclude::where('workshop_id','=',$id)->get();
        $workwhatlearn = Workwhatlearn::where('workshop_id','=',$id)->get();

        $money = Currency::first();
        $amount = Currency::orderby('id','desc')->first();

       
        return view('admin.workshop.show',compact('money','amount','cor','course','workshopinclude','workwhatlearn'));
    }

    public function WorkshopDetailPage($id,$slug){
        $course = Workshop::findOrFail($id);
       
        $workshopinclude = Workshopinclude::where('workshop_id','=',$id)->get();
        $workwhatlearn = Workwhatlearn::where('workshop_id','=',$id)->get();
     
       	//  $clientIP = request()->ip();
        //  $countryip = \Location::get($clientIP);
        //  $userip = $countryip->countryCode;
        //  $counname = $countryip->countryName;
         
       
  $currency_value=Session::get('currency_value');
   
         $money = Currency::where('currency',$currency_value)->first();
         if(empty($money))
         {
            $money = Currency::where('countrycode','IN')->first();
         }

        return view('front.workshop_detail',compact('course','workshopinclude','workwhatlearn','money'));

       }
  
  

    

}
