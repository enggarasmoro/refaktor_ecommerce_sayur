<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bank;
use Validator;
use Intervention\Image\Facades\Image;

class BankController extends Controller
{
    public function index()
    {
        $title = 'Config Bank';

        return view('backoffice.bank.index',compact('title'));
    }

    public function getdata()
    {
        $databank = DB::table('bank')->whereIn('status', [0, 1])->get();
        return response()->json(array('data' => $databank));
    }

    public function showmodal()
    {
        $type = "simpan";
        return view('backoffice.bank.modal',compact('type'))->render();
    }

    public function showmodaledit($id)
    {
        $type = "edit";
        $bank = Bank::find($id);
        return view('backoffice.bank.modal',compact('type','bank'))->render();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' =>  'required',
            'norek' =>  'required',
            'atasnama' =>  'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }
        $input = $request->except('_token');
        if ($request->hasFile('foto')) {
            $filename = $input['nama'] . '.jpg';
            $input['foto'] = 'images/bank/'.$filename;
            // $canvas = Image::canvas(900, 600);
            $resizeImage  = Image::make($request->file('foto'))->resize(900, 600, function($constraint) {
                $constraint->aspectRatio();
            });
            $resizeImage->insert($resizeImage, 'center');
            $resizeImage->save('frontend/images/bank/' . $filename);
        }
        DB::beginTransaction();
        try { 
            $input['created_at'] = now();
            DB::table('bank')->insert($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Menambahkan Data Bank']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function edit(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'nama' =>  'required',
            'norek' =>  'required',
            'atasnama' =>  'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:3048',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errorsvalidation' => $validator->errors()->all()]);
        }

        if ($request->hasFile('foto')) {
            $filename = $input['nama'] . '.jpg';
            $input['foto'] = 'images/bank/'.$filename;
            // $canvas = Image::canvas(900, 600);
            $resizeImage  = Image::make($request->file('foto'))->resize(900, 600, function($constraint) {
                $constraint->aspectRatio();
            });
            $resizeImage->insert($resizeImage, 'center');
            $resizeImage->save('frontend/images/bank/' . $filename);
        }

        DB::beginTransaction();
        try { 
            DB::table('bank')->where('id', $input['id'])->update($input);
            DB::commit();            
            return response()->json(['success'=>'Berhasil Update Data Bank']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try { 
            DB::table('bank')->where('id', $id)->update(['status' => 2]);
            DB::commit();
            return response()->json(['success'=>'Berhasil Delete Data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors'=>'Terjadi Kesalahan Silahkan Coba lagi.']);
        }
            
    }
}
