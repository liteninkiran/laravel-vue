@extends('layouts.main')

@section('content')

    <div class="row">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">States</h1>
        </div>

        {{-- Create Record --}}
        <div class="ml-auto">
            <a href="{{ route('states.create') }}" class="btn btn-primary mb-2">Create</a>
        </div>

    </div>

    <div class="card mx-auto">

        {{-- Show messages --}}
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        {{-- Top Bar --}}
        <div class="card-header">

            <div class="row">

                {{-- Filters --}}
                <div class="col">

                    <form method="GET" action="{{ route('states.index') }}">

                        <div class="form-row">

                            {{-- Country Drop-Down --}}
                            <div class="col" style="flex: 5;">
                                <select id="search_country" name="country_id" class="form-control" aria-label="Default select example">
                                    <option {{ $country_id === null ? 'selected' : '' }} value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option {{ $country_id === $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Search State --}}
                            <div class="col" style="flex: 5;">
                                <input type="search" name="search" class="form-control mb-2" id="search_state" placeholder="Search states" value="{{ $search }}">
                            </div>

                            {{-- Submit Button --}}
                            <div class="col" style="flex: 1.2;">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>

                            {{-- Clear Form --}}
                            <div class="col" style="flex: 1.2;">
                                <button class="btn btn-primary mb-2" onclick="document.getElementById('search_country').value = ''; document.getElementById('search_state').value = null;">
                                    CLEAR
                                </button>
                            </div>

                            {{-- Spacing --}}
                            <div style="flex: 10;">&nbsp;</div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

        {{-- States --}}
        <div class="card-body">

            <table class="table">

                {{-- Table Header Row --}}
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Country</th>
                        <th scope="col">Name</th>
                        <th scope="col" colspan="2">Manage</th>
                    </tr>
                </thead>

                {{-- Table Data --}}
                <tbody>
                    @foreach ($states as $state)
                        <tr>
                            <th scope="row">{{ $state->id }}</th>
                            <td>{{ $state->country->name }}</td>
                            <td>{{ $state->name }}</td>
                            <td>
                                <a href="{{ route('states.edit', $state->id) }}" class="btn btn-success">Edit</a>

                            </td>

                            <td>
                                @if ($state->employees_count === 0 && $state->cities_count === 0)
                                    <form method="POST" action="{{ route('states.destroy', $state->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

@endsection
