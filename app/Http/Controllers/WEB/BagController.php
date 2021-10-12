<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        $person = Person::all();
        $bag = Bag::with('person')->orderByDesc('updated_at')->get();
        return view('bag.index', ['bag'=>$bag, 'person' => $person]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $person = Person::all();
        return view('bag.add', ['person' => $person]);
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
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'number' => 'required|integer',
                    'brand' => 'required|string',
                    'people_id' => 'required|integer'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $bag=new Bag();
            $bag->number=$request->number;
            $bag->brand=$request->brand;
            $bag->people_id=$request->people_id;
            $bag->save();
            return redirect()->route('bag.index')->with('success', 'Bag Add Successfull');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors('Uppss, Something is wrong!!!');
        }
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
        $bag = Bag::where('id','=',base64_decode($id))->first();
        if (empty($bag))
            return redirect()->back()->withErrors('Bag not Found');
        $person = Person::all();

        return view('bag.edit', ['bag'=>$bag,'person'=>$person]);
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
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'number' => 'required|integer',
                    'brand' => 'required|string',
                    'people_id' => 'required|integer'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $bag = Bag::find(base64_decode($id));
            $bag->number=$request->number;
            $bag->brand=$request->brand;
            $bag->people_id=$request->people_id;
            $bag->save();
            return redirect()->route('bag.index')->with('success', 'Bag Updated successfully');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors('Upps, something is wrong');
        }
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
        $bag = Bag::find($id);

        if($bag){
            $bag->delete();

            Session::flash('warning', 'Warning');
            return redirect()->back()->with('warning', 'Bag deleted');
        }

        Session::flash('error', 'Error');
        return redirect()->back()->with('error', 'Upps, something is wrong');
    }
}
