@extends('layouts.form')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" id="email" class="fadeIn second @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">
        @error('email')
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
        <input type="submit" class="fadeIn fourth" value=" {{ __('Login') }}">
    </form>
    <!-- Remind Passowrd -->
    <div id="formFooter">
        @if (Route::has('password.request'))
            <a class="underlineHover" href="{{ route('password.request') }}"> {{ __('Forgot Your Password?') }}</a>
        @endif
    </div>
@endsection
