@extends('layouts.form')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" id="name" class="fadeIn second @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('User Name') }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="email" id="name" class="fadeIn second @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}">
        @error('name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="password" id="password" class="fadeIn third @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
        @error('password')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input id="password-confirm" type="password" class="fadeIn" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Password Confirm') }}">
        <input type="submit" class="fadeIn fourth" value=" {{ __('Register') }}">
    </form>
    <!-- Remind Passowrd -->
    <div id="formFooter">
        @if (Route::has('password.request'))
            <a class="underlineHover" href="{{ route('password.request') }}"> {{ __('Forgot Your Password?') }}</a>
        @endif
    </div>
@endsection





