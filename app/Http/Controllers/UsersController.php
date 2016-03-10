<?php

namespace AmigosLabels\Http\Controllers;

use Auth, Input, Redirect;
use Illuminate\Http\Request;

use AmigosLabels\Courier;
use AmigosLabels\User;
use AmigosLabels\Http\Requests;
use AmigosLabels\Http\Controllers\Controller;

class UsersController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('auth.admin', ['except' => [
			'edit', 'update'
		]]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Kind of a complex query just so we can sort by institution name.
		$users = User::leftJoin('institutions', function($j) {
					$j->on('institutions.id', '=', 'users.institution_id');
				})
				->orderBy('institutions.name', 'asc')
		   		->select('users.*')
		   		->with('institution')
				->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$tae = Courier::where('code', 'TAE')->get()->first();
        return view('auth.register', ['institutions' => $tae->institutions->lists('full_name', 'id')]);
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
			'username' => 'required|max:255',
			'institution_id' => 'integer',
			'password' => 'confirmed|min:6'
		]);
		
		$data = $request->all();
		
		if (empty($data['institution_id'])) unset($data['institution_id']);
		if (empty($data['username'])) unset($data['username']);
		$data['password'] = bcrypt($data['password']);
		
		User::create($data);
		return Redirect::route('users.index');
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
		# We only want each user to edit their own password (or admins)
		if (!Auth::user()->admin && Auth::user()->id != $id) {
			return Redirect::route('home');
		}
		
		$tae = Courier::where('code', 'TAE')->with('institutions')->get()->first();

        return view('users.edit', ['user' => User::find($id), 'institutions' => $tae->institutions->lists('full_name', 'id')]);
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
		$rules = ['password' => 'confirmed|min:6'];
		
		if (Auth::user()->admin) {
            $rules['username'] = 'required|max:255';
			$rules['institution_id'] = 'integer';
		}

		$this->validate($request, $rules);

		if (Auth::user()->admin) {
			$data = Input::only(['username', 'institution_id', 'admin']);
			$data['admin'] = (Input::has('admin')) ? true : false;
			
			if (empty($data['institution_id'])) $data['institution_id'] = null;
		}
		
		$data['password'] = Input::get('password');

		if (!empty($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		}
		else {
			unset($data['password']);
		}

        User::find($id)->update($data);
		return Redirect::route(Auth::user()->admin ? 'users.index' : 'home');
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
