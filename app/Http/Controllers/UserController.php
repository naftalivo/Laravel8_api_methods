<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = Arr::flatten($validator->messages()->toArray());
            return response()->json(['state' => 412, 'message' => $error], 200);
        }


        $user= User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'state'=>412,
                'message' => "Email or password wrong",
                'data'=>[]
            ], 200);
        }
        $user->tokens()->delete();


        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'state'=>200,
            'message'=>"Login successfull",
            'data'=>array(
                'user' => $user,
                'token' => $token
            )

        ];

        return response($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        /*create the Token*/
        $token = $user->createToken('obterToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return $response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function logout(){
        auth()->user()->tokens()->delete();

        $response = [
            'state'=>200,
            'message'=>"Logged Out Successfully",
            'data'=>array()

        ];

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){

        $rules = [
            // 'email' => 'required|email',
            'name' => 'required|string',
        ];

        $validate = Validator::make($request->all(),$rules);

        if ($validate->fails()) {
            return response()->json(['message'=>$validate->errors(),'state'=>412],200);
        }
        $user=  $request->user();
        $users=User::find($user->id);
        $users->phone_number=$request->phone_number;
        $users->name=$request->name;
        $users->save();
        $user=User::find($user->id);

        if($user->count()==0){
            return   response([
                'state'=>412,
                'message'=>"User not found",
                'data'=>[]
            ],412);
        }

        $token =$user->createToken('my-app-token')->plainTextToken;

        $response = [
            'state'=>200,
            'message'=>"Data updated successfully",
            'data'=>array(
                'user'=>$user,
                'token'=>$token
            )
        ];

        return $response;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
