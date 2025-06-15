@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-gradient-primary text-white">
                <h4 class="m-0 font-weight-bold text-center">Login</h4>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            @if ($error == 'Email atau password salah.')
                                Email atau password salah.
                            @elseif ($error == 'Email belum terdaftar.')
                                Email belum terdaftar.
                            @else
                                {{ $error }}
                            @endif
                        @endforeach
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="remember">Remember Me</label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="text-center mt-3">
                        <p class="mb-2 text-muted">Atau login dengan:</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('google.redirect') }}" class="btn btn-danger btn-sm mr-2"><i class="fab fa-google fa-sm"></i> Google</a>
                            <a href="{{ route('github.redirect') }}" class="btn btn-dark btn-sm"><i class="fab fa-github fa-sm"></i> GitHub</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection