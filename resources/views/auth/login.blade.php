@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="username"> Username:</label>
                            <input
                                id="username"
                                type="text"
                                placeholder="Username"
                                class="form-control {{ $errors->has("username") ? "is-invalid" : "" }}"
                                name="username"
                                value="{{ old("username") }}"
                            />
                            @foreach($errors->get("username") ?? [] as $feedback)
                                <span class="invalid-feedback">
                                {{ $feedback }}
                            </span>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="password"> Password:</label>
                            <input
                                id="password"
                                type="password"
                                placeholder="Password"
                                class="form-control {{ $errors->has("password") ? "is-invalid" : "" }}"
                                name="password"
                                value="{{ old("password") }}"
                            />
                            @foreach($errors->get("password") ?? [] as $feedback)
                                <span class="invalid-feedback">
                                {{ $feedback }}
                            </span>
                            @endforeach
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
