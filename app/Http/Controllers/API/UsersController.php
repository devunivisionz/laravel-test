<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Handlers\Error;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller{
    
    const ControllerCode = 'U_';

    public function getUserData(Request $request){
        try {

            $validator = Validator::make($request->all(),[
                'offset' => 'numeric',
                'limit' => 'numeric'
            ]);

            if($validator->fails()){
                throw new \Exception($validator->errors(),1);
            }

            $validated = $validator->validated();

            $users = User::orderBy('id','DESC');

            $total_count = $users->count();

            if(isset($validated['offset']) && $validated['offset']){
                $users = $users->offset($validated['offset']);
            }

            if(isset($validated['limit']) && $validated['limit']){
                $users = $users->limit($validated['limit']);
            }else{
                $users = $users->limit(10);
            }

            $users = $users->get();

            $count = $users->count();

            return response()->json([
                "status" => true,
                "data" => [
                    "data" => $users,
                    "total_count" => $total_count,
                    "count" => $count
                ]
            ]);

        } catch (\Throwable $e) {

            return Error::Handle($e, self::ControllerCode, '01');

        }
    }

    public function createUser(Request  $request){

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9_\- ]*$/|max:50',
                'email' => 'required|max:100|email|unique:users',
                'phone' => 'required|string|max:20',
                'photo' => 'required|mimes:jpeg,jpg,png,gif',
                'password' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors(),1);
            }

            $validated = $validator->validated();
            
            $validated['password'] = Hash::make($validated['password']);
            $validated['photo'] = $request->file('photo')->store('uploads','public');

            $objUser = User::create($validated);
            
            return response()->json([
                "status"=>true,
                "message"=> "User created successfully."
            ]);

        } catch (\Exception $e) {

            return Error::Handle($e, self::ControllerCode, '02');
        }

    }

    public function userInfo(Request $request, $id){
        try {
            $Info =  User::find($id);

            if (!$Info) {
                throw new \Exception("User Not Found");
            }

            $Info->photo = asset('storage/'.$Info->photo);
            
            return response()->json([
                "status" => true,
                "data" => $Info
            ]);
        } catch (\Exception $e) {

            return Error::Handle($e, self::ControllerCode, '03');
        }
    }

    public function updateUser(Request  $request){

        try {

            $validator = Validator::make($request->all(), [
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
            
            return response()->json([
                "status"=>true,
                "message"=> "User updated successfully."
            ]);


        } catch (\Exception $e) {

            return Error::Handle($e, self::ControllerCode, '04');
        }

    }

    public function deleteUser($id){
        try {

            $user = User::find($id);

            if (!$user) {
                throw new \Exception("User Not Found");
            }

            $user = $user->delete();

            return response()->json([
                'success' => true,
                'message' => "User deleted successfully."
            ]);
        } catch (\Throwable $e) {
            return Error::Handle($e, self::ControllerCode, '04');
        }
    }
    
}
