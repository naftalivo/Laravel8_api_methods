<?php

namespace App\Http\Controllers\WEB;

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
        $person = Person::orderByDesc('updated_at')->get();
        return view('person.index', ['person'=>$person]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('person.create');
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
                    'name' => 'required|string',
                    'age' => 'required|integer',
                    'address' => 'required|string',
                    'phone' => 'required|integer'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $person = new Person();
            $person->name = $request->name;
            $person->age = $request->age;
            $person->address = $request->address;
            $person->phone = $request->phone;
            $person->save();
            return redirect()->route('person.index')->with('success', 'Person created successfully');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors('Upps, something is wrong!!!');
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
        $person = Person::where('id','=',base64_decode($id))->first();
        if (empty($person))
            return redirect()->back()->withErrors('person not found');

        return view('person.edit', ['person'=>$person]);
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
                    'name' => 'required|string',
                    'age' => 'required|integer',
                    'address' => 'required|string',
                    'phone' => 'required|integer'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $person = Person::find(base64_decode($id));
            $person->name = $request->name;
            $person->age = $request->age;
            $person->address = $request->address;
            $person->phone = $request->phone;
            $person->save();

            return redirect()->back()->with('success', 'Person updated successfully');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors('Upps, something is wrong!!!');
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
        $person = Person::find($id);

        if($person){
            $person->delete();

            Session::flash('warning', 'Warning');
            return redirect()->back()->with('warning', 'Person deleted');
        }

        Session::flash('error', 'Error');
        return redirect()->back()->with('error', 'Upps, something is wrong!!!');
    }
}
