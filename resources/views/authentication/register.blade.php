@extends('authentication.layouts.main')

@section('page-content')
<div class="col-lg-5 col-md-7">
    <div class="card bg-secondary border-0 mb-0">
        <div class="card-header bg-transparent">
            <div class="text-muted text-center mt-2 mb-2"><h1>{{ $title }}</h1></div>
        </div>
        <div class="card-body px-lg-5 py-lg-5">
            <form action="/register" method="post" role="form" novalidate>
                @csrf
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                        </div>
                        <input class="form-control" name="name" placeholder="Nama panggilan" type="text" value="{{ old('name') }}" required>
                    </div>
                    @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                        </div>
                        <input class="form-control" name="username" placeholder="Username" type="text" value="{{ old('username') }}" required>
                    </div>
                    @error('username')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control" name="email" placeholder="Email" type="email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" name="password" placeholder="Password" type="password" required>
                    </div>
                    @error('password')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" name="confirm_password" placeholder="Konfirmasi passwords" type="password" required>
                    </div>
                    @error('confirm_password')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="row my-4">
                    <div class="col-12">
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                            <label class="custom-control-label" for="customCheckRegister">
                            <span class="text-muted">I agree with the <a href="#!">Privacy Policy</a></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-4">Registrasi</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-6">
        <a href="#" class="text-light"><small>Forgot password?</small></a>
        </div>
        <div class="col-6 text-right">
        <a href="/login" class="text-light"><small>Sudah punya akun</small></a>
        </div>
    </div>
</div>
@endsection
