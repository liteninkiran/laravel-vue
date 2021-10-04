<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Http\Requests\CityUpdateRequest;
use App\Http\Requests\CityStoreRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        // Store search filters
        $search = $request->has('search') ? $request->search : null;
        $country_id = $request->has('country_id') ? (int)$request->country_id : null;
        $state_id = $request->has('state_id') ? (int)$request->state_id : null;

        // Retrieve countries for filtering
        $countries = Country::query()
            ->orderBy('name', 'asc')
            ->get();

        // Retrieve states for filtering
        $states = State::query()
            ->when($country_id, function($query) use ($country_id) {
                return $query->where('country_id', '=', $country_id);
            })
            ->orderBy('name', 'asc')
            ->get();

        // Start a query builder for cities
        $queryBuilder = City::query()

        // Conditionally search by City
        ->when($search, function($query) use ($search) {
            return $query->where('cities.name', 'like', "%{$search}%");
        })

        // Conditionally search by State
        ->when($state_id, function($query) use ($state_id) {
            return $query->where('state_id', '=', $state_id);
        })

        // Conditionally search by Country
        ->when($country_id, function($query) use ($country_id) {
            return $query->whereExists(function ($query) use ($country_id) {
                $query->selectRaw(1)
                      ->from('states')
                      ->whereColumn('states.id', 'cities.state_id')
                      ->where('states.country_id', '=', $country_id);
            });
        })

        // Join to states to order properly
        ->join('states', 'states.id', '=', 'cities.state_id')

        // Join to countries to order properly
        ->join('countries', 'countries.id', '=', 'states.country_id')

        // Order by country
        ->orderBy('countries.name', 'asc')

        // Order by state
        ->orderBy('states.name', 'asc')

        // Order by city
        ->orderBy('cities.name', 'asc')

        // Avoid getting duplicates by only selecting the states
        ->select('cities.*');

        // Retrieve the data
        $cities = $queryBuilder
            ->withCount('employees')
            ->get();

        return view('cities.index', compact('cities', 'states', 'countries', 'search', 'country_id', 'state_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $states = State::query()
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->orderBy('countries.country_code', 'asc')
            ->orderBy('states.name', 'asc')
            ->select('states.*')
            ->get();

        return view('cities.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request) {
        City::create([
            'name' => $request->name,
            'state_id' => $request->state_id,
        ]);

        return redirect()->route('cities.index')->with('message', 'City Created Successfully');
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
        $states = State::query()
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->orderBy('countries.country_code', 'asc')
            ->orderBy('states.name', 'asc')
            ->select('states.*')
            ->get();
        $city = City::withCount('employees')->findOrFail($id);
        return view('cities.edit', compact('city', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\CityUpdateRequest $request
     * @param  City $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update([
            'name' => $request->name,
            'state_id' => $request->state_id,
        ]);

        return redirect()->route('cities.index')->with('message', 'City Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $city = City::withCount('employees')->findOrFail($id);

        if ($city->employees_count === 0) {
            $city->delete();
            return redirect()->route('cities.index')->with('message', 'City Deleted Successfully');
        }
        return redirect()->route('cities.index')->with('message', 'Could not delete city ' . $city->name);
    }
}
