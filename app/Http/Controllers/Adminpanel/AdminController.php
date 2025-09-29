<?php

namespace App\Http\Controllers\Adminpanel;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class AdminController extends Controller
{
    
    public function index()
    {
        $title = 'Master Admin';

        return view('backoffice.admin.index',compact('title'));
    }

   
    public function getdata()
    {
        $dataadmin = Admin::all();
        return response()->json(array('data' => $dataadmin));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.admin.modal',compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $admin = Admin::find($id);
        return view('backoffice.admin.modal',compact('type','admin'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'username' => 'required|unique:admin',
            'nohp' => 'required|string|max:12',
            'email' => 'required|email',
            'status' => 'required',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        DB::beginTransaction();
        try { 
            $input = $request->except('_token');
            $input['password'] = bcrypt($input['password']);
            $input['created_at'] = now();
            DB::table('admin')->insert($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Menambahkan User']);
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
            'username' => 'required|unique:admin,username,' . $input['id'],
            'nohp' => 'required|string|max:12',
            'email' => 'required|email',
            'status' => 'required',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        DB::beginTransaction();
        try { 
            $input['password'] = bcrypt($input['password']);
            $input['updated_at'] = now();
            DB::table('admin')->where('id', $input['id'])->update($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Update User']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try { 
            $admin = Admin::find($id);
            $admin->delete();
            DB::commit();            
            return response()->json(['success'=>'Berhasil Delete Data']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
            
    }

    
}
