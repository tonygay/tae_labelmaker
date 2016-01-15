<?php

namespace AmigosLabels\Http\Controllers;

use Input, Redirect;
use Illuminate\Http\Request;

use AmigosLabels\Courier;
use AmigosLabels\Institution;
use AmigosLabels\Http\Requests;
use AmigosLabels\Http\Controllers\Controller;
use AmigosLabels\Http\Requests\InstitutionListImport;

class InstitutionsController extends Controller
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
        return view('institutions.index', [
			'institutions' => Institution::with('courier')->get(),
			'courier_id' => 0,
			'couriers' => Courier::orderBy('name')->lists('name', 'id')
		]);
    }
	
	/**
	 * Display a filtered listing of the resource
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function filteredIndex()
	{
		$courier_id = Input::get('courier_id');
		$query = Institution::with('courier')->where('courier_id', $courier_id);
		return view('institutions.index', [
			'institutions' => $query->get(),
			'courier_id' => $courier_id,
			'couriers' => Courier::orderBy('name')->lists('name', 'id')
		]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('institutions.edit', [
			'institution' => new Institution,
			'couriers' => Courier::orderBy('name')->lists('name', 'id')
		]);
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
			'courier_id' => 'required|integer',
            'oclc' => 'required|max:255',
            'hub' => 'max:255',
			'site_code' => 'max:255',
			'address1' => 'max:255',
			'address2' => 'max:255',
			'city' => 'max:255',
			'state' => 'max:255',
			'postal_code' => 'max:12',
        ]);
		
		$data = Input::all();

        Institution::create($data);
		return Redirect::route('institutions.index');
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
		return view('institutions.edit', [
			'institution' => Institution::find($id),
			'couriers' => Courier::orderBy('name')->lists('name', 'id')
		]);
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
			'courier_id' => 'required|integer',
            'oclc' => 'required|max:255',
            'hub' => 'max:255',
			'site_code' => 'max:255',
			'address1' => 'max:255',
			'address2' => 'max:255',
			'city' => 'max:255',
			'state' => 'max:255',
			'postal_code' => 'max:12',
        ]);
		
		$data = Input::all();

        Institution::find($id)->update($data);
		return Redirect::route('institutions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Institution::find($id)->delete();
		return Redirect::route('institutions.index');
    }
	
	public function upload()
	{
		return view('institutions.upload', ['couriers' => Courier::lists('name', 'id')]);
	}
	
	public function import(InstitutionListImport $import)
	{
		// get the imported data
		$courier_id = Input::get('courier_id');
		$results = $import->get($courier_id);
		return view('institutions.index', [
			'institutions' => Institution::with('courier')->where('courier_id', $courier_id)->get(),
			'results' => $results,
			'courier_id' => $courier_id,
			'couriers' => Courier::orderBy('name')->lists('name', 'id')
		]);
	}
	
	public function listJson()
	{
		// Return active institutions as a JSON list
		$list = Institution::with('courier')->get();
		return response()->json($list);
	}
}
