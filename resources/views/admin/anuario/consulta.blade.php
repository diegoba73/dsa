@extends('layouts.app')

@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="content">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif   
    <div class="card bg-gradient-default mt-3 mb-2 mb-lg-0">
                    <div class="card-body">
                    <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                        <div style="float: left;">
                            <div class="container-fluid">
                            <h2 style = "color: white">Consulta de anuario de muestras</h2>
                            <form method="GET" action="{{ route('anuario_resultados') }}">
                                <div class="d-inline-block">
                                    <div class="form-group">
                                        <label for="year1" style="color: white; margin-right: 10px;">Año:</label>
                                        <select class="form-control" name="year" id="year">
                                            @for ($i = date('Y'); $i >= 2018; $i--)
                                                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </form>
                            </div>
                        </div>
                    </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection