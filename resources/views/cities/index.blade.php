@extends('layouts.main')

@section('content')

    <div class="row">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cities</h1>
        </div>

        {{-- Create Record --}}
        <div class="ml-auto">
            <a href="{{ route('cities.create') }}" class="btn btn-primary mb-2">Create</a>
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

                    <form method="GET" action="{{ route('cities.index') }}">

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

                            {{-- State Drop-Down --}}
                            <div class="col" style="flex: 5;">
                                <select id="search_state" name="state_id" class="form-control" aria-label="Default select example">
                                    <option {{ $state_id === null ? 'selected' : '' }} value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option {{ $state_id === $state->id ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Search City --}}
                            <div class="col" style="flex: 5;">
                                <input type="search" name="search" class="form-control mb-2" id="search_city" placeholder="Search cities" value="{{ $search }}">
                            </div>

                            {{-- Submit Button --}}
                            <div class="col" style="flex: 1.2;">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>

                            {{-- Clear Form --}}
                            <div class="col" style="flex: 1.2;">
                                <button class="btn btn-primary mb-2" onclick="document.getElementById('search_country').value = ''; document.getElementById('search_state').value = ''; document.getElementById('search_city').value = null;">
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

        {{-- Cities --}}
        <div class="card-body">

            <table class="table">

                {{-- Table Header Row --}}
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Country</th>
                        <th scope="col">State</th>
                        <th scope="col">Name</th>
                        <th scope="col" colspan="2">Manage</th>
                    </tr>
                </thead>

                {{-- Table Data --}}
                <tbody>
                    @foreach ($cities as $city)
                        <tr>
                            <th scope="row">{{ $city->id }}</th>
                            <td>{{ $city->state->country->name }}</td>
                            <td>{{ $city->state->name }}</td>
                            <td>{{ $city->name }}</td>
                            <td>
                                <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-success">Edit</a>

                            </td>

                            <td>
                                @if ($city->employees_count === 0)
                                    <form method="POST" action="{{ route('cities.destroy', $city->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                @else
                                    {{ $city->employees_count }}
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="pagination-block">
                {{ $cities->links('layouts.pagination') }}
            </div>

        </div>

    </div>

@endsection
