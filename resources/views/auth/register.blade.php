@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-gradient-primary text-white">
                <h4 class="m-0 font-weight-bold text-center">Register</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mt-3">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required />
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mt-3">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mt-3">
                        <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
                    </div>

                    <!-- Role -->
                    <div class="form-group mt-3">
                        <label for="role" class="font-weight-bold">Role</label>
                        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                            <option value="wartawan">Wartawan</option>
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="text-center mt-3">
                        <p class="mb-2 text-muted">Atau daftar dengan:</p>
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