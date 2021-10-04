@extends('layouts.main')

@section('content')

    <div class="row">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Departments</h1>
        </div>

        {{-- Create Record --}}
        <div class="ml-auto">
            <a href="{{ route('departments.create') }}" class="btn btn-primary mb-2">Create</a>
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

                    <form method="GET" action="{{ route('departments.index') }}">

                        <div class="form-row align-items-center">

                            {{-- Search Department --}}
                            <div class="col" style="flex: 5;">
                                <input type="search" name="search" class="form-control mb-2" id="search_department" placeholder="Search departments" value="{{ $search }}">
                            </div>

                            {{-- Submit Button --}}
                            <div class="col" style="flex: 1.2;">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>

                            {{-- Clear Form --}}
                            <div class="col" style="flex: 1.2;">
                                <button class="btn btn-primary mb-2" onclick="document.getElementById('search_department').value = '';">
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

        {{-- Departments --}}
        <div class="card-body">

            <table class="table">

                {{-- Table Header Row --}}
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col" colspan="2">Manage</th>
                    </tr>
                </thead>

                {{-- Table Data --}}
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <th scope="row">{{ $department->id }}</th>
                            <td>{{ $department->name }}</td>
                            <td>
                                <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-success">Edit</a>

                            </td>

                            <td>
                                @if ($department->employees_count === 0)
                                    <form method="POST" action="{{ route('departments.destroy', $department->id) }}">
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
