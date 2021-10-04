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

        $countries = Country::query()
            ->orderBy('name', 'asc')
            ->get();

        $search = $request->has('search') ? $request->search : null;
        $country_id = $request->has('country_id') ? (int)$request->country_id : null;

        // Return requested state records
        $queryBuilder = State::query()

        // Conditionally search by State
        ->when($search, function($query) use ($search) {
            return $query->where('states.name', 'like', "%{$search}%");
        })

        // Conditionally search by Country
        ->when($country_id, function($query) use ($country_id) {
            return $query->where('country_id', '=', $country_id);
        })

        // Join to countries to order properly
        ->join('countries', 'countries.id', '=', 'states.country_id')

        // Order by country
        ->orderBy('countries.name', 'asc')

        // Order by state
        ->orderBy('states.name', 'asc')

        // Avoid getting duplicates by only selecting the states
        ->select('states.*');

        $states = $queryBuilder->get();

        return view('states.index', compact('states', 'search', 'countries', 'country_id'));
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

        return redirect()->route('states.index')->with('message', 'State Created Successfully');
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
