@extends('layouts.app', ['title' => __('Usuarios')])

@section('content')
    @include('users.partials.header', ['title' => __('Editar Usuario')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-right">
                            <div class="col-10">
                                <h3 class="mb-0">{{ __('Usuarios') }}</h3>
                            </div>
                            <form method="POST" action="{{ route('user.toggle-status', $user) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->activo ? 'btn-danger' : 'btn-success' }}">
                                {{ $user->activo ? __('Desactivar') : __('Activar') }}
                            </button>
                            </form>
                            <div class="col-1 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Listado') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('user.update', $user) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Información del Usuario') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Usuario') }}</label>
                                    <input type="text" name="usuario" id="input-name" class="form-control form-control-alternative{{ $errors->has('Usuario') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuario') }}" value="{{ old('usuario', $user->usuario) }}" required autofocus>

                                    @if ($errors->has('Usuario'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('usuario') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', $user->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('departamento_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-departamento_id">{{ __('Departamento') }}</label>
                                    <select name="departamento_id" id="input-departamento_id" class="form-control form-control-alternative{{ $errors->has('departamento_id') ? ' is-invalid' : '' }}" required>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}" {{ old('departamento_id', $user->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                                {{ $departamento->departamento }} <!-- Muestra el nombre del departamento -->
                                            </option>
                                        @endforeach
                                    </select>

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
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }} <!-- Muestra el nombre del rol -->
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('role_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="">
                                    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmar Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirmar Password') }}" value="">
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Actualizar') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection