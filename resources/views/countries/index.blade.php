@extends('layouts.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Countries</h1>
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

                {{-- Search countries --}}
                <div class="col">
                    <form method="GET" action="{{ route('countries.index') }}">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <input type="search" name="search" class="form-control mb-2" id="inlineFormInput" placeholder="Search countries" value="{{ $search }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Create Record --}}
                <div>
                    <a href="{{ route('countries.create') }}" class="btn btn-primary mb-2">Create</a>
                </div>

            </div>

        </div>

        {{-- Countries --}}
        <div class="card-body">

            <table class="table">

                {{-- Table Header Row --}}
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Country Code</th>
                        <th scope="col">Name</th>
                        <th scope="col" colspan="2">Manage</th>
                    </tr>
                </thead>

                {{-- Table Data --}}
                <tbody>
                    @foreach ($countries as $country)
                        <tr>
                            <th scope="row">{{ $country->id }}</th>
                            <td>{{ $country->country_code }}</td>
                            <td>{{ $country->name }}</td>
                            <td>
                                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-success">Edit</a>

                            </td>

                            <td>
                                @if ($country->states_count === 0)
                                    <form method="POST" action="{{ route('countries.destroy', $country->id) }}">
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
