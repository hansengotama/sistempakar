@extends('layouts.app')

@section('style')
    <style>
        .login-text {
            margin-bottom: 1em;
            font-size: 24px;
        }
        .form-container {
            margin: 0 3em;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ url('img/prostatpic.jpg') }}" alt="prostatpic" width="100%">
        </div>
        <div class="col-md-6" style="padding: 7em 0">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="text-center login-text">Login Page</div>
                <div class="form-container">
                    <input name="username"
                           type="text"
                           class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                           value="{{ old('username') }}"
                           placeholder="username"
                           required />
                    <input name="password"
                           type="password"
                           class="form-control mt-3{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           value="{{ old('password') }}"
                           placeholder="password"
                           required />
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button class="btn btn-primary ml-2"
                            style="background-color: white; color: #3590dc"
                            data-toggle="modal"
                            data-target="#register-modal"
                    >Registrasi</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="register-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Register</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="modal-body form-group">
                        <input id="name"
                               type="text"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}"
                               placeholder="full name"
                               name="name"
                               required />
                        <input id="username"
                               type="text"
                               class="form-control mt-3{{ $errors->has('username') ? ' is-invalid' : '' }}"
                               placeholder="username"
                               value="{{ old('username') }}"
                               name="username"
                               required />
                        <input id="password"
                               type="password"
                               class="form-control mt-3{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               placeholder="password"
                               value="{{ old('password') }}"
                               name="password"
                               required />
                        <input id="age"
                               type="text"
                               class="form-control mt-3{{ $errors->has('age') ? ' is-invalid' : '' }}"
                               placeholder="age"
                               value="{{ old('age') }}"
                               name="age"
                               required />
                        <select id="gender"
                                class="form-control mt-3{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                name="gender">
                            <option>pria</option>
                            <option>wanita</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection