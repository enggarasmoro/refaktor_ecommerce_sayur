<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Intervention\Image\Facades\Image;

class NewslatterController extends Controller
{
    public function index()
    {
        $title = 'Master News latter';

        return view('backoffice.newslatter.index',compact('title'));
    }

    public function getdata()
    {
        $newslatter = DB::table('newslatter')->whereIn('status', ['0', '1'])->get();
        return response()->json(array('data' => $newslatter));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.newslatter.modal',compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $newslatter = DB::table('newslatter')
            ->select('newslatter.*')
            ->where('id', $id)->first();
        return view('backoffice.newslatter.modal',compact('type','newslatter'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' =>  'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $lastid = DB::table('newslatter')->select('id')->orderBy('id','desc')->first();
        $id = (isset($lastid)?$lastid->id+1:1);
        $input = $request->except('_token');
        if ($request->hasFile('image')) {
            $filename = $id . '.jpg';
            $input['image'] = 'images/newslatter/'.$filename;
            // $canvas = Image::canvas(1920, 815);
            $resizeImage  = Image::make($request->file('image'))->resize(770, 500, function($constraint) {
                $constraint->aspectRatio();
            });
            $resizeImage->insert($resizeImage, 'center');
            $resizeImage->save('frontend/images/newslatter/' . $filename);
        }
        DB::beginTransaction();
        try { 
            $input['created_at'] = now();
            DB::table('newslatter')->insert($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Menambahkan Data Newslatter']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'keterangan' =>  'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:3048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $gambar = DB::table('newslatter')->where('id', $input['id'])->first();
        if ($request->hasFile('image')) {
            $filename = $input['id'] .date('YmdHis'). '.jpg';
            unlink('/home/u937293872/domains/paksayur.com/public_html/frontend/'.$gambar->image);
            $input['image'] = 'images/newslatter/'.$filename;
            // $canvas = Image::canvas(1920, 815);
            $resizeImage  = Image::make($request->file('image'))->resize(770, 500, function($constraint) {
                $constraint->aspectRatio();
            });
            $resizeImage->insert($resizeImage, 'center');
            $resizeImage->save('frontend/images/newslatter/' . $filename);
        }

        DB::beginTransaction();
        try { 
            DB::table('newslatter')->where('id', $input['id'])->update($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Update Data Newslatter']);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try { 
            DB::table('newslatter')->where('id', $id)->update(['newslatter.status' => 3]);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
            
    }
}
