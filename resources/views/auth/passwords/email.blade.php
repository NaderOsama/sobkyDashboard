@extends('layouts.guest')

@section('content')
    <div class="loader-wrapper">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="card card-authentication1" style="direction: rtl; text-align: right;">
                <div class="card-body">
                    <div class="card-content">
                        <div class="text-center">
                            <img src="{{ asset('images/car-logo.png') }}" class="img-fluid w-25" alt="رمز الشعار">
                        </div>
                        <div class="card-header">{{ __('إعادة تعيين كلمة المرور') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="col-form-label text-md-end py-3">{{ __('عنوان البريد الإلكتروني') }}</label>
                                    <input id="email" type="email" class="form-control p-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="d-grid text-center m-1">
                                    <button type="submit" class="btn btn-primary w-50">
                                        {{ __('  إعادة تعيين كلمة المرور') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
