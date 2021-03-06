<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Requests\CountryUpdateRequest;
use App\Http\Requests\CountryStoreRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = '';

        if ($request->has('search')) {

            $search = $request->search;

            $countryBuilder = Country::query()
                ->where('name', 'like', "%{$search}%");
        } else {
            $countryBuilder = Country::query();
        }

        $countries = $countryBuilder
            ->withCount('states')
            ->withCount('cities')
            ->withCount('employees')
            ->orderBy('name', 'asc')
            ->paginate(env('PAGINATION_LENGTH'));

        return view('countries.index', compact('countries', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryStoreRequest $request) {
        Country::create([
            'name' => $request->name,
            'country_code' => $request->country_code,
        ]);

        return redirect()->route('countries.index')->with('message', 'Country Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id) {
        $country = Country::query()
            ->withCount('states')
            ->withCount('cities')
            ->withCount('employees')
            ->findOrFail($id);
        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Country $country
     * @return \Illuminate\Http\Response
     */
    public function update(CountryUpdateRequest $request, Country $country) {
        $country->update([
            'name' => $request->name,
            'country_code' => $request->country_code,
        ]);

        return redirect()->route('countries.index')->with('message', 'Country Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $country = Country::query()
            ->withCount('states')
            ->withCount('cities')
            ->withCount('employees')
            ->findOrFail($id);

        if ($country->states_count === 0 && $country->employees_count === 0) {
            $country->delete();
            return redirect()->route('countries.index')->with('message', 'Country Deleted Successfully');
        }
        return redirect()->route('countries.index')->with('message', 'Could not delete country ' . $country->name);
    }
}
