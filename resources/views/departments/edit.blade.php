@extends('layouts.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Departments</h1>
    </div>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    {{-- Sub Heading --}}
                    <div class="card-header">

                        {{ __('Update Department') }}

                        {{-- Back Button --}}
                        <a href="{{ route('departments.index') }}" class="float-right">Back</a>

                    </div>

                    <div class="card-body">

                        {{-- Form --}}
                        <form method="POST" action="{{ route('departments.update', $department->id) }}">

                            {{-- Tokens --}}
                            @csrf
                            @method('PUT')

                            {{-- Department Name --}}
                            <div class="form-group row">

                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $department->name) }}" required autocomplete="name" autofocus>

                                    {{-- Error messages --}}
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            {{-- Submit Button --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Department') }}
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

                {{-- Delete Record --}}
                @if ($department->employees_count === 0)
                    <div class="m-2 p-2">

                        {{-- Form --}}
                        <form method="POST" action="{{ route('departments.destroy', $department->id) }}">

                            {{-- Tokens --}}
                            @csrf
                            @method('DELETE')

                            {{-- Submit Button --}}
                            <button class="btn btn-danger">Delete {{ $department->name }}</button>

                        </form>

                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
