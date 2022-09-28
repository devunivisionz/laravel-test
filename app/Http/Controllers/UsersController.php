<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Handlers\Error;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller{
    
    const ControllerCode = 'U_';

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Users Listing';
        $this->outputData['dataTables'] = url('users/datatable');
        $this->outputData['delete'] = url('users/delete');
        $this->outputData['create'] = url('users/create');
        $this->outputData['edit'] = url('users/edit');
        return view('pages.user.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            try {
                $datas = User::orderBy('id','desc')->get();

                return DataTables::of($datas)
                ->addColumn('photo',function(User $data){
                    return asset('storage/'.$data->photo);
                })
                ->rawColumns(['photo'])
                ->toJson();
            } catch (\Throwable $e) {
                return Error::Handle($e, self::ControllerCode, '01');
            }
        }
    }

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'name' => 'required|regex:/^[a-zA-Z0-9_\- ]*$/|max:50',
                    'email' => 'required|max:100|email|unique:users',
                    'phone' => 'required|string|max:20',
                    'photo' => 'required|mimes:jpeg,jpg,png,gif',
                    'password' => 'required|string|max:20',
                ]);
    
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first());
                }
                
                $validated = $validator->validated();
                
                $validated['password'] = Hash::make($validated['password']);
                //--- Insert Record
                $validated['photo'] = $request->file('photo')->store('uploads','public');

                $objUser = User::create($validated);

                return response()->json(['success' => "User created successfully."]);
            }
            $this->outputData['pageName'] = 'New User';
            $this->outputData['action'] = url('users/store');
            return view('pages.user.create',$this->outputData);
        } catch (\Throwable $e) {
            return Error::Handle($e, self::ControllerCode, '01');
        }        
    }

    public function edit(Request $request,$id){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'id' => 'required|exists:users',
                    'name' => 'required|regex:/^[a-zA-Z0-9_\- ]*$/|max:50',
                    'email' => 'required|max:100|email|unique:users',
                    'phone' => 'required|string|max:20',
                    'photo' => 'mimes:jpeg,jpg,png,gif',
                ]);
    
                if ($validator->fails()) {
                    throw new \Exception($validator->errors(),1);
                }
    
                $validated = $validator->validated();
                
                if(isset($validated['photo']) && $validated['photo']){
                    $validated['photo'] = $request->file('photo')->store('uploads','public');
                }
    
                $objUser = User::find($validated['id'])->update($validated);

                return response()->json(['success' => "User updated successfully."]);
            }
            $this->outputData['pageName'] = 'Edit User';
            $this->outputData['action'] = url('users/update/'.$id);
            $this->outputData['objData'] = User::findOrFail($id);
            return view('pages.user.create',$this->outputData);
        } catch (\Throwable $e) {
            return Error::Handle($e, self::ControllerCode, '01');
        }
    }

    public function destroy($id){
        try {
            $res = User::find($id)->delete();   
            return response()->json(true);
        } catch (\Throwable $e) {
            return Error::Handle($e, self::ControllerCode, '01');
        }
    }
}

