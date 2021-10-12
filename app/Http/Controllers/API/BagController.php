<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $validate = Bag::with("person")->get();
        $person = Person::all();


        $response = [
            'state'=>200,
            'message'=>"Successfull",
            'data'=> array(
                'people'=>$person,
                'bags'=>$validate
            )
        ];


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
            'number' => 'required|integer',
            'brand' => 'required|string',
            'people_id' => 'required|integer'
        ];
        $validate = Validator::make($request->all(),$rules);

        if ($validate->fails()) {
            return response()->json(['message'=>$validate->errors(),'state'=>412],200);
        }

        $bag = \App\Models\Bag::create($request->all());

        if($bag){
            $response = [
                'state'=>200,
                'message'=>"Successfull",
                'data'=>array($bag)
            ];
        }else{
            $response = [
                'state'=>500,
                'message'=>"Error",
                'data'=>array($bag)
            ];
        }

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
        $bag = \App\Models\Bag::find($id);

        if($bag){
            $response = [
                'state'=>200,
                'message'=>"Successfull",
                'data'=>array($bag)
            ];
        }else{
            $response = [
                'state'=>500,
                'message'=>"Error data not found",
                'data'=>array($bag)
            ];
        }

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
        $bag = Bag::where('id','=',base64_decode($id))->first();

        if (empty($bag)){
            $response = [
                'state'=>500,
                'message'=>"Data not found",
                'data'=>array($bag)
            ];
        }else{
            $response = [
                'state'=>200,
                'message'=>"Successfull",
                'data'=>array($bag)
            ];
        }

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
            'number' => 'required|integer',
            'brand' => 'required|string',
            'people_id' => 'required|integer'
        ];
        $bag = Bag::find($id);
        $bag -> update($request->all());

        $validate = Validator::make($request->all(),$rules);
        if ($validate->fails()) {

            $response = [
                'state'=>500,
                'message'=>"Error data not updated",
                'data'=>array($bag)
            ];

        }else{
            $response = [
                'state'=>200,
                'message'=>"Data updated successfully",
                'data'=>array($bag)

            ];
        }
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
