<?php

namespace AmigosLabels\Http\Controllers;

use Illuminate\Http\Request;

use Input, Redirect;
use AmigosLabels\Courier;
use AmigosLabels\Http\Requests;
use AmigosLabels\Http\Controllers\Controller;

class CouriersController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('auth.admin');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('couriers.index', ['couriers' => Courier::withTrashed()->with('institutions')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('couriers.edit', ['courier' => new Courier]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request, [
            'name' => 'required|max:255',
            'code' => 'required|max:255'
        ]);
		
		$data = Input::only(['name', 'code', 'label_display_preferences']);

        Courier::create($data);
		return Redirect::route('couriers.index');
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
        return view('couriers.edit', ['courier' => Courier::withTrashed()->find($id)]);
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
		$this->validate($request, [
            'name' => 'required|max:255',
            'code' => 'required|max:255'
        ]);
		
		$data = Input::only(['name', 'code']);
		$prefs = Input::get('label_preferences_json');

		$address = Input::get('use_address');
		$prefs['use_address1'] = ($address == 'use_address1' || $address == 'use_address_both');
		$prefs['use_address2'] = ($address == 'use_address2' || $address == 'use_address_both');

        $courier = Courier::withTrashed()->find($id);
		$courier->label_preferences_json = $prefs;
		$courier->update($data);

		return Redirect::route('couriers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Courier::find($id)->delete();
		return Redirect::route('couriers.index');
    }
	
    /**
     * Restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Courier::withTrashed()->find($id)->restore();
		return Redirect::route('couriers.index');
    }
	
    /**
     * Remove all institutions relations for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeInstitutions($id)
    {
        $courier = Courier::withTrashed()->with('institutions')->find($id);
		foreach ($courier->institutions as $institution) $institution->delete();
		return Redirect::route('couriers.index');
    }
}
