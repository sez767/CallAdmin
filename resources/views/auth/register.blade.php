@extends('layouts.app')

@section('content')
    @component('components.full-page-section')
        @component('components.card')
            @slot('title')
                <span class="icon"><i class="mdi mdi-account-check"></i></span>
                <span>{{ __('Регистрация') }}</span>
            @endslot

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label class="label" for="email">{{ __('Имя') }}</label>
                    <div class="control">
                        <input id="name" type="text" class="input @error('name') is-danger @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    @error('name')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="email">{{ __('E-Mail адрес') }}</label>
                    <div class="control">
                        <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password" autofocus>
                    </div>
                    @error('password')
                    <p class="help is-danger" role="alert">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password-confirm">{{ __('Повторите пароль') }}</label>
                    <div class="control">
                        <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password" autofocus>
                    </div>
                </div>

                <hr>

                <div class="field is-form-action-buttons">
                    <button type="submit" class="button is-black">
                        {{ __('Регистрация') }}
                    </button>

                    <a class="button is-black is-outlined" href="{{ route('login') }}">
                        {{ __('Войти') }}
                    </a>
                </div>
            </form>

        @endcomponent
    @endcomponent

@endsection
