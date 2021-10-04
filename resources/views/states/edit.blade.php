@extends('layouts.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">States</h1>
    </div>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    {{-- Sub Heading --}}
                    <div class="card-header">

                        {{ __('Update State') }}

                        {{-- Back Button --}}
                        <a href="{{ route('states.index') }}" class="float-right">Back</a>

                    </div>

                    <div class="card-body">
    
                        {{-- Form --}}
                        <form method="POST" action="{{ route('states.update', $state->id) }}">
    
                            {{-- Tokens --}}
                            @csrf
                            @method('PUT')

                            {{-- State Name --}}
                            <div class="form-group row">

                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $state->name) }}" required autocomplete="name" autofocus>

                                    {{-- Error messages --}}
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            {{-- Country --}}
                            <div class="form-group row">

                                <label for="country_code" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                                <div class="col-md-6">

                                    {{-- Drop-Down Menu --}}
                                    <select name="country_id" class="form-control" aria-label="Default select example" required>
                                        <option disabled value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option {{ $state->country_id === $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                    {{-- Error Message --}}
                                    @error('country_code')
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
                                        {{ __('Update State') }}
                                    </button>
                                </div>
                            </div>
    
                        </form>
    
                    </div>
    
                </div>

                {{-- Delete Record --}}
                @if ($state->employees_count === 0 && $state->cities_count === 0)
                    <div class="m-2 p-2">

                        {{-- Form --}}
                        <form method="POST" action="{{ route('states.destroy', $state->id) }}">

                            {{-- Tokens --}}
                            @csrf
                            @method('DELETE')

                            {{-- Submit Button --}}
                            <button class="btn btn-danger">Delete {{ $state->name }}</button>

                        </form>

                    </div>
                @endif

            </div>
    
        </div>
    
    </div>
    
@endsection
