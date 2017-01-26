<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\UploadImage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    
    public function images()
    {
    	return view('admin.images');
    }

    /**
     * Show the application ajaxImageUploadPost.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxImageUploadPost(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'title' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if ($validator->passes()) {
        $input = $request->all();
        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('upload_imgs'), $input['image']);

        UploadImage::create($input);

        return response()->json(['success'=>'done']);
      }

      return response()->json(['error'=>$validator->errors()->all()]);
    }
}
