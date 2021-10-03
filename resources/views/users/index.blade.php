@extends('layouts.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>

    <div class="card mx-auto">

        {{-- Top Bar --}}
        <div class="card-header">

            <div class="row">

                {{-- Search users --}}
                <div class="col">
                    <form method="GET" action="{{ route('users.index') }}">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <input type="search" name="search" class="form-control mb-2" id="inlineFormInput" placeholder="Search users" value="{{ $search }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Create User --}}
                <div>
                    <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Create</a>
                </div>

            </div>

        </div>

        {{-- Users --}}
        <div class="card-body">

            <table class="table">

                {{-- Table Header Row --}}
                <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col" colspan="2">Manage</th>
                    </tr>
                </thead>

                {{-- Table Data --}}
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Edit</a>

                            </td>

                            <td>
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
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
