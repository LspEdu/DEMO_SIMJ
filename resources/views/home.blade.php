@extends('adminlte::page')




@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario del evento -->
                    <form id="eventForm" action="{{route('event.create')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="title">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="start">Fecha y hora de inicio</label>
                            <input type="datetime-local" class="form-control" id="start" name="start" required>
                        </div>
                        <div class="form-group">
                            <label for="end">Fecha y hora de fin</label>
                            <input type="datetime-local" class="form-control" id="end" name="end" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo Evento</label>
                            <select class="form-select" name="tipo" id="tipo">
                                @foreach ($tiposEventos as $tipo)
                                    <option style="color: {{$tipo->color}}" value="{{$tipo->id}}"  >{{$tipo->tipo}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cerrarModal">Cerrar</button>
                            <button type="button" class="btn btn-danger" id="btnConfirmarBorrar" >Eliminar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="confirmarBorrar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Eliminar Evento</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para eliminar usuario -->
                    <form id="eliminarEvento" action="{{ route('event.destroy') }}" method="post">
                        @method('DELETE')
                        @csrf

                        <input type="hidden" id="destroyEventId" name="id">
                        <h4>¿Estás seguro/a de eliminar este evento? Esta acción es irreversible</h4>

                        <div class="col-12 d-flex justify-content-between ">
                            <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endsection
