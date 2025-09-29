<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Master User';

        return view('backoffice.user.index', compact('title'));
    }


    public function getdata()
    {
        $datausers = DB::table('users')->get();
        return response()->json(array('data' => $datausers));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.user.modal', compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $user = User::find($id);
        return view('backoffice.user.modal', compact('type', 'user'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'email' => 'required|unique:users|email',
            'nohp' => 'required|string|max:12|unique:users',
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
            DB::table('users')->insert($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambahkan User']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'email' => 'required|email|unique:users,email,' . $input['id'],
            'nohp' => 'required|string|max:12|unique:users,nohp,' . $input['id'],
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $password = $input['password'];
            unset($input['password']);
            if ($password != null) {
                $input['password'] = bcrypt($password);
            }
            $input['updated_at'] = now();
            DB::table('users')->where('id', $input['id'])->update($input);
            DB::commit();
            return response()->json(['success' => 'Berhasil Update User']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    // public function delete($id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $admin = Admin::find($id);
    //         $admin->delete();
    //         DB::commit();
    //         return response()->json(['success' => 'Berhasil Delete Data']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['errors' => 'Terjadi Kesalahan Silahkan Coba lagi.']);
    //     }
    // }
}
