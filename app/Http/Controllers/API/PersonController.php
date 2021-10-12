<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $response = [
            'state'=>200,
            'message'=>"Successfull",
            'data'=>array(Person::all())

        ];

        $validate = Person::all();

        if (empty($validate)) {
            return response()->json(['message'=>$validate->errors('No data found'),'success'=>false],200);
        }else
            return $response;
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
        $rules =[
            'name'=>'required|string',
            'age'=>'required|integer',
            'address'=>'required|string',
            'phone'=>'required|integer'
        ];
        $response = [
            'state'=>200,
            'message'=>"Person created successfully",
            'data'=>array(\App\Models\Person::create($request->all()))

        ];

        $validate = Validator::make($request->all(),$rules);
        if ($validate->fails()) {
            return response()->json(['message'=>$validate->errors(),'success'=>false],200);
        }else
            return $response;
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
        $response = [
            'state'=>200,
            'message'=>"Successfull",
            'data'=>array(\App\Models\Person::find($id))

        ];

        return $response;
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
        $person = Person::where('id','=',base64_decode($id))->first();
        $response = [
            'state'=>200,
            'message'=>" Successfull",
            'data'=>array($person)

        ];
        if (empty($person))
            return redirect()->back()->withErrors('Data not found');

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules =[
            'name' => 'required|string',
            'age' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|integer'
        ];
            $person = Person::find($id);
            $person -> update($request->all());
            $response = [
                'state'=>200,
                'message'=>"Person updated successfully",
                'data'=>array($person)

            ];
            $validate = Validator::make($request->all(),$rules);
            if ($validate->fails()) {
                return response()->json(['message'=>$validate->errors(),'success'=>false],200);
            }else
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
