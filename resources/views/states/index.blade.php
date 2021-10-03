@extends('layouts.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">States</h1>
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

                {{-- Search states --}}
                <div class="col">
                    <form method="GET" action="{{ route('states.index') }}">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <input type="search" name="search" class="form-control mb-2" id="inlineFormInput" placeholder="Search states" value="{{ $search }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Create Record --}}
                <div>
                    <a href="{{ route('states.create') }}" class="btn btn-primary mb-2">Create</a>
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
                                <form method="POST" action="{{ route('states.destroy', $state->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

@endsection
