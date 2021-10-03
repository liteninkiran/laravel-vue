<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;

class StateController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $search = $request->has('search') ? $request->search : '';

        $states = State::query()
        ->when($search, function($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                    $q->where('states.name', 'like', "%{$search}%")
                      ->orWhereExists(function($q2) use ($search) {
                          $q2->selectRaw(1)
                             ->from('countries')
                             ->whereRaw("`countries`.`id` = `states`.`country_id` AND `countries`.`name` LIKE '%{$search}%'");
                      });
                });
            })
        ->orderBy('country_id', 'asc')
        ->orderBy('name', 'asc')
        ->get();

        return view('states.index', compact('states', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $countries = Country::query()
        ->orderBy('name', 'asc')
        ->get();

        return view('states.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        State::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
        ]);

        return redirect()->route('states.index')->with('message', 'State Created Succesfully');
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
