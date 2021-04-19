@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="/login">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-header card-header-warning text-center">
                        <h4 class="card-title"><strong>{{ __('Login') }}</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="" required>
                            </div>
                            @if ($errors->has('email'))
                                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" value="" required>
                            </div>
                            @if ($errors->has('password'))
                                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-check mr-auto ml-3 mt-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-warning btn-link btn-lg">{{ __('Login') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    body, html {
        height: 100%;
        background-image: url("asset/img/login-bg-new.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
@endpush