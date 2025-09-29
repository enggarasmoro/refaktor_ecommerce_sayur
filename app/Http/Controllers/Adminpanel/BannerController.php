<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Facades\DB;
use Validator;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function index()
    {
        $title = 'Master Banner';

        return view('backoffice.banner.index',compact('title'));
    }

    public function getdata()
    {
        $databanner = Banner::all();
        return response()->json(array('data' => $databanner));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.banner.modal',compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $banner = Banner::find($id);
        return view('backoffice.banner.modal',compact('type','banner'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $lastid = DB::table('banner')->select('id')->orderBy('id','desc')->first();
        $id = (isset($lastid)?$lastid->id+1:1);
        $input = $request->except('_token');
        if ($request->hasFile('image')) {
            $filename = $id . '.jpg';
            $input['image'] = 'images/banner/'.$filename;
            // $canvas = Image::canvas(1920, 815);
            $resizeImage  = Image::make($request->file('image'))->resize(1920, 815, function($constraint) {
                $constraint->aspectRatio();
            });
            $resizeImage->insert($resizeImage, 'center');
            $resizeImage->save('frontend/images/banner/' . $filename);
        }
        DB::beginTransaction();
        try { 
            $input['created_at'] = now();
            DB::table('banner')->insert($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Menambahkan Data banner']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:3048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }

        if ($request->hasFile('image')) {
            $filename = $input['id'] . '.jpg';
            $input['image'] = 'images/banner/'.$filename;
            // $canvas = Image::canvas(1920, 815);
            $resizeImage  = Image::make($request->file('image'))->resize(1920, 815, function($constraint) {
                $constraint->aspectRatio();
            });
            $resizeImage->insert($resizeImage, 'center');
            $resizeImage->save('frontend/images/banner/' . $filename);
        }

        DB::beginTransaction();
        try { 
            DB::table('banner')->where('id', $input['id'])->update($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Update Data Banner']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try { 
            $admin = Banner::find($id);
            $admin->delete();
            DB::commit();            
            return response()->json(['success'=>'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
            
    }
}
