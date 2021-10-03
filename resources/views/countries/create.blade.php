@extends('layouts.main')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Countries</h1>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Country') }}
                        <a href="{{ route('countries.index') }}" class="float-right">Back</a>
                    </div>
    
                    <div class="card-body">
    
                        {{-- Form --}}
                        <form method="POST" action="{{ route('countries.store') }}">
    
                            {{-- Token --}}
                            @csrf

                            {{-- Country Name --}}
                            <div class="form-group row">

                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    {{-- Error messages --}}
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            {{-- Country Code --}}
                            <div class="form-group row">

                                <label for="country_code" class="col-md-4 col-form-label text-md-right">{{ __('Country Code') }}</label>

                                <div class="col-md-6">

                                    <input id="country_code" type="text" class="form-control @error('country_code') is-invalid @enderror" name="country_code" value="{{ old('country_code') }}" required autocomplete="country_code" autofocus>

                                    {{-- Error messages --}}
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
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
    
                        </form>
    
                    </div>
    
                </div>
    
            </div>
    
        </div>
    
    </div>
    
@endsection
