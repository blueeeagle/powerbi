<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use App\Users;
use App\Categories;
use App\Groups;
use App\UsersCategories;
use App\UsersGroups;
use Illuminate\Support\Facades\Hash;


class UsersController extends ApiController
{
    public function getApiKey()
    {
        $data = ["apiKey" => "FIT@2022"];

        return $this->successResponse($data);
    }

    public function index()
    {
        $users = Users::all();

        return $this->successResponse($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'firstName'   => 'required',
                    'email'       => 'required|email|unique:users',
                    'password'     => 'required',            
                    'groupId'     => 'required|integer',
                    //'phoneNumber' => 'required', 
                ]);
        if($validator->fails()) { 
            $message = $validator->errors();
            $array = json_decode(json_encode($message), true);
            foreach($array as $key => $check){
                $messageArray[] = $check['0'];                
            }
            $messageString = implode(',', $messageArray);
            return $this->errorResponse($messageString, 400);  
        }
        else { 
            $categoryId = $request->categoryId;
            $categories = Categories::where("id", $categoryId)->first();
            $groups = Groups::where("id", $request->groupId)->first();
            if (is_null($groups)) { 
                return $this->errorResponse('invalid group Id', 400);
            }
            else if(isset($request->categoryId) && is_null($categories)) {
                return $this->errorResponse('invalid category Id', 400);
            }
            else {
                $imagePath = '/uploads/users/';
                $path = storage_path() . $imagePath;
                if($request->file('image'))
                {
                    $file = $request->file('image');                    
                    $file->move($path, $file->getClientOriginalName());            
                    $image = URL::to('').'/storage'.$imagePath.$file->getClientOriginalName();
                }
                else {
                    $image = URL::to('').'/storage'.$imagePath.'default-image.jpg';
                }

                $requests = $request->all();
                $requests['password'] = Hash::make(rtrim($requests['password']));
                $requests['image'] = $image;
                $users = Users::create($requests);

                if($request->categoryId !="") {
                    $categoryId = $request->categoryId;
                    $categoryArr = explode(',', $categoryId);                
                    foreach ($categoryArr as $key => $value) {
                        $userCat = new UsersCategories([
                            'userId'     => $users->id,
                            'categoryId'      => $value
                        ]);
                        $userCat->save();
                    }
                }

                $userGrp = new UsersGroups([
                    'userId'    => $users->id,
                    'groupId'   => $request->groupId
                ]);
                $userGrp->save();

                return $this->successResponse($users,'User registered successfully', 201);
            }            
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();            
        $validator = Validator::make($request->all(), [
                        'email'   => ['string', 'email', Rule::unique('users')->ignore($id)]                                        
                    ]);
        if($validator->fails()) { 
            $message = $validator->errors();
            $array = json_decode(json_encode($message), true);
            foreach($array as $key => $check){
                $messageArray[] = $check['0'];                
            }
            $messageString = implode(',', $messageArray);
            return $this->errorResponse($messageString, 400); 
        }
        else { 
            $users = Users::where("id",$id)->first();        
            if (is_null($users)) {
                return $this->errorResponse('users not found.', 404);
            }

            if($request->file('image'))
            { 
                $file = $request->file('image');
                $imagePath = '/uploads/users/';
                $path = storage_path() . $imagePath;
                $file->move($path, $file->getClientOriginalName());            
                $image = URL::to('').'/storage'.$imagePath.$file->getClientOriginalName();
            }
            else {
                $image = $users['image'];
            }

            $requests = $request->all();
            if(isset($requests['password']) && $requests['password']!="") {
                $requests['password'] = Hash::make(rtrim($requests['password']));
            }
            else {
                $requests['password'] = $users['password'];
            }
            $requests['image'] = $image;
            $categoryId = $request->categoryId;
            unset($requests['categoryId']);
            unset($requests['_method']);
            Users::where("id",$id)->update($requests);
            if($categoryId !="") {
                $categoryArr = explode(',', $categoryId);   
                UsersCategories::where('userId', '=', $users['id'])->delete();              
                foreach ($categoryArr as $key => $value) {
                    $userCat = new UsersCategories([
                        'userId'     => $users['id'],
                        'categoryId'      => $value
                    ]);
                    $userCat->save();
                }
            }
            $users = Users::where("id",$id)->first();

            return $this->successResponse($users,'User details Updated', 200);
        }
    }

    public function show($id)
    {
        $users = Users::where("id", $id)->first();
        if (is_null($users)) {
            return $this->errorResponse('users not found.', 404);
        }

        return $this->successResponse($users->toArray(), 'user retrieved successfully.');
    }

    public function destroy($id)
    {
        $users = Users::where("id", $id)->first();
        if (is_null($users)) {
            return $this->errorResponse('users not found.', 404);
        }
        else {
            $requests['isDeleted'] = 1;
            Users::where("id",$id)->update($requests);
            return $this->successResponse('', 'user deleted successfully.');
        }        
    }

    public function login(Request $request) {  
        $validator = Validator::make($request->all(), [
                'email'         => 'required|email',            
                'password'      => 'required|string',
            ]);
        if($validator->fails()) { 
            $message = $validator->errors();
            $array = json_decode(json_encode($message), true);
            foreach($array as $key => $check){
                $messageArray[] = $check['0'];                
            }
            $messageString = implode(',', $messageArray);
            return $this->errorResponse($messageString, 400);
        }
        else {
            $user = Users::where('email', $request->email)->first();
            if($user) {
                if(Hash::check(rtrim($request->password), $user->password))
                {      
                    $token = $user->createToken('LaravelAuthApp')->accessToken;
                    $user['token'] = $token; 
                    return $this->successResponse($user->toArray(), 'Logged successfully.');                    
                }
                else {
                    return $this->errorResponse('Invalid Password.', 400);                   
                }
            }
            else {
                return $this->errorResponse('Invalid Email', 400);                     
            }
        }
    }
}
