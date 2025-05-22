@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'users.create', 'title' => __('Sistema DPSA')])

@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
    <div class="container-">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            @if (session('notification'))
                <div class="alert alert-success">
                    {{ session('notification') }}
                </div>
            @endif
        </div>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Agregar Usuario</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('user.store') }}" autocomplete="off">
                                @csrf
                                
                                <h6 class="heading-small text-muted mb-4">{{ __('Información de Usuario') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('usuario') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-usuario">{{ __('Usuario') }}</label>
                                        <input type="text" name="usuario" id="input-usuario" class="form-control form-control-alternative{{ $errors->has('usuario') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuario') }}" value="{{ old('usuario') }}" required autofocus>

                                        @if ($errors->has('usuario'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('usuario') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @php
                                        $currentUser = auth()->user();
                                        $isDBUser = $currentUser->departamento_id == 2;
                                    @endphp

                                    <div class="form-group{{ $errors->has('departamento_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-departamento_id">{{ __('Departamento') }}</label>
                                        <select name="departamento_id" id="input-departamento_id" class="form-control form-control-alternative{{ $errors->has('departamento_id') ? ' is-invalid' : '' }}" required {{ $isDBUser ? 'disabled' : '' }}>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                                    {{ $departamento->departamento }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($isDBUser)
                                            <input type="hidden" name="departamento_id" value="2">
                                        @endif

                                        @if ($errors->has('departamento_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('departamento_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-role_id">{{ __('Rol') }}</label>
                                        <select name="role_id" id="input-role_id" class="form-control form-control-alternative{{ $errors->has('role_id') ? ' is-invalid' : '' }}" required>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('role_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('activo') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-activo">{{ __('Activo') }}</label>
                                        <input type="checkbox" name="activo" id="input-activo" value="1" {{ old('activo') ? 'checked' : '' }}>

                                        @if ($errors->has('activo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('activo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                        <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" required>
                                        
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmar Password') }}</label>
                                        <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirmar Password') }}" required>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Guardar') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            @include('layouts.footers.auth')
        </div>
    </div>
</div>
@endsection