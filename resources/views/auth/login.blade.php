@extends('layouts.app')

@section('content')
    @component('components.full-page-section')



        @component('components.card')
            @slot('title')
                <span class="icon"><i class="mdi mdi-lock"></i></span>
                <span>{{ __('Войти') }}</span>
            @endslot

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label class="label" for="email">{{ __('E-Mail адрес') }}</label>
                    <div class="control">
                        <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password">{{ __('Пароль') }}</label>
                    <div class="control">
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password" autofocus>
                    </div>
                    @error('password')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="control">
                    <label tabindex="0" class="b-checkbox checkbox is-thin">
                        <input type="checkbox" value="false" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="check is-black"></span>
                        <span class="control-label">{{ __('Запомнить меня') }}</span>
                    </label>
                    <hr>
                    @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}">
                            {{ __('Забыли пароль?') }}
                        </a>
                    @endif
                    
                </div>

                

                <div class="field is-form-action-buttons">
                    <button type="submit" class="button is-black">
                        {{ __('Войти') }}
                    </button>
                    <a href="{{ route('register') }}" class="button is-black is-outlined">Зарегестрироватся</a>
                </div>
            </form>
        @endcomponent
    @endcomponent
@endsection
