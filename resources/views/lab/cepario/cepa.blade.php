@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.cepario.cepa', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">

                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                </div>
            <div class="content bg-primary">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Ingreso Cepa</strong>
                                </div>
                                <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/lab/cepario/'.$microorganismo->id.'/cepa') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="row">
                                    <input name="url" type="hidden" value=$url>
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr><strong>
                                                    <th>Número</th>
                                                    <th>Microorganismo</th>
                                                    <th>Medio de Cultivo</th>
                                                    <th>Condiciones</th>
                                                    <th>Proveedor</th>                                                    
                                                </strong>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> {{ $microorganismo->numero }} </td>
                                                    <td> {{ $microorganismo->microorganismo }} </td>
                                                    <td> {{ $microorganismo->medio_cultivo }} </td>
                                                    <td> {{ $microorganismo->condiciones }} </td>
                                                    <td> {{ $microorganismo->proveedor->empresa }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                                      
                                        <table class="table rounded">
                                            <thead class="thead-dark">
                                                <tr><strong>
                                                    <th>Registro Id</th>
                                                    <th>Fecha Incubación</th>
                                                    <th>Lote</th>
                                                    <th>Observaciones</th>
                                                    <th>Usuario</th>
                                                    <th>
                                                    </strong>
                                                    <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregar">
                                                    <i class="fas fa-plus"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                @foreach ($cepas as $cepa)
                                                <tr>
                                                    <td> {{ $cepa->id }} </td>
                                                    @if (strtotime($cepa->fecha_incubacion) > 0)
                                                    <td> {{ date('d-m-Y', strtotime($cepa->fecha_incubacion)) }} </td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                    <td> {{ $cepa->lote }} </td>
                                                    <td> {{ $cepa->observaciones }} </td>
                                                    <td> {{ $cepa->user->usuario }} </td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-round btn-sm" data-cid="{{$cepa->id}}" data-cincubacion="{{$cepa->fecha_incubacion}}" data-clote="{{$cepa->lote}}" data-ctsi="{{$cepa->tsi}}" data-ccitrato="{{$cepa->citrato}}" data-clia="{{$cepa->lia}}" data-curea="{{$cepa->urea}}" data-csim="{{$cepa->sim}}" data-cesculina="{{$cepa->esculina}}" data-chemolisis="{{$cepa->hemolisis}}" data-ctumbling="{{$cepa->tumbling}}" data-cfluorescencia="{{$cepa->fluorescencia}}" data-ccoagulasa="{{$cepa->coagulasa}}" data-coxidasa="{{$cepa->oxidasa}}" data-ccatalasa="{{$cepa->catalasa}}" data-cgram="{{$cepa->gram}}" data-cobservaciones="{{$cepa->observaciones}}" data-toggle="modal" data-target="#editarc">
                                                        <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            
                                            </tbody>
                                            
                                        </table>   
                                        <br>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                    <a class="btn btn-default btn-close" href="{{ route('lab_cepario_index') }}">Cerrar</a>
                                </div>                                         
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div> 

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Agregar Cepa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('cepa.store')}}" method="post">
      		{{csrf_field()}}
        
	      <div class="modal-body">
            <div class="form-group">
            <input type="hidden" class="form-control" name="id" value="{{$microorganismo->id}}">
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="incubacion">Incubación</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="incubacion">
                    </div>
                </div>
                <div class="col-4">
                    <label class="control-label col-sm"for="lote">Lote</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="lote">
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="tsi">TSI</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="tsi">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="citrato">Citrato</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="citrato">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="lia">LIA</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="lia">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="urea">Urea</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="urea">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="sim">SIM</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="sim">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-6"for="esculina">Esculina</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="esculina">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-4"for="hemolisis">Hemólisis</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="hemolisis">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="tumbling">Tumbling</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="tumbling">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm-6"for="fluorescencia">Fluorescencia</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="fluorescencia">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-6"for="coagulasa">Coagulasa</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="coagulasa">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-6"for="oxidasa">Oxidasa</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="oxidasa">
                    </div>
                </div>
                <div class="col-2">
                <label class="control-label col-sm-6"for="catalasa">Catalasa</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="catalasa">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="gram">Gram</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="gram">
                    </div>
                </div>
                <div class="col-9">
                <label class="control-label col-sm-6"for="observaciones">Observaciones:</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="observaciones">
                    </div>
                </div>
            </div>
            </div>
	      </div>
        
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar</button>
	      </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="editarc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Editar Cepa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('cepa.update', 'id')}}" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	    <div class="modal-body">
                <input name="url" type="hidden" value="{{ $url }}">
                <input type="hidden" class="form-control" name="id" id="id" value="">
            
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="incubacion">Incubación</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="incubacion" id="incubacion">
                    </div>
                </div>
                <div class="col-4">
                    <label class="control-label col-sm"for="lote">Lote</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="lote" id="lote">
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="tsi">TSI</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="tsi" id="tsi">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="citrato">Citrato</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="citrato" id="citrato">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="lia">LIA</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="lia" id="lia">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="urea">Urea</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="urea" id="urea">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="sim">SIM</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="sim" id="sim">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-6"for="esculina">Esculina</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="esculina" id="esculina">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-4"for="hemolisis">Hemólisis</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="hemolisis" id="hemolisis">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="tumbling">Tumbling</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="tumbling" id="tumbling">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm-6"for="fluorescencia">Fluorescencia</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="fluorescencia" id="fluorescencia">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-6"for="coagulasa">Coagulasa</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="coagulasa" id="coagulasa">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm-6"for="oxidasa">Oxidasa</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="oxidasa" id="oxidasa">
                    </div>
                </div>
                <div class="col-2">
                <label class="control-label col-sm-6"for="catalasa">Catalasa</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="catalasa" id="catalasa">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="gram">Gram</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="gram" id="gram">
                    </div>
                </div>
                <div class="col-9">
                <label class="control-label col-sm-6"for="observaciones">Observaciones:</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="observaciones" id="observaciones">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <br>
	      </div>
	      </div>
	     
      </form>
    </div>
  </div>
</div>

@endsection