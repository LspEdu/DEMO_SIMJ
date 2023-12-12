@extends('adminlte::page')

@section('content_header')
    <h1>
        <i class="fa fa-calendar-day"></i> Listado de Tipos de Eventos
    </h1>
    <hr>
@endsection

@section('content')
    @if (session('success'))
        <div class="m-3 bg-success rounded text-center">
            <h3 class="text-light">{{ session('success') }}</h3>
        </div>
    @endif
    <div class="row d-flex justify-between">
        <div class="col">

            <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#crearTipoModal"><i
                    class="fa fa-plus mr-1"></i>Añadir</button>
            <button class="btn btn-primary ml-1" onclick="location.reload()"><i
                    class="fa fa-sync-alt mr-1"></i>Recargar</button>
            <button class="btn btn-primary ml-1" onclick="history.back()"><i
                    class="fa fa-arrow-left mr-1"></i>Volver</button>
        </div>
    </div>

    <div class="row bg-light shadow-lg mt-2 p-1 rounded">
        <div class="col mt-2">
            <p>Mostrar <select class="custom-select form-control-sm" name="reg" id="reg" style="width: 4em"
                    onchange="loadUser()">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>registros</p>
            <table class="table table-striped border text-center">
                <thead class="bg-blue">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Color</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipos as $tipo)
                        <tr>
                            <td>{{ $tipo->id }}</td>
                            <td>{{ $tipo->tipo }}</td>
                            <td style="display:inline-block">
                                {{ $tipo->color }}
                                <div style="width:4em; height:1em; background-color: {{ $tipo->color }}"></div>
                            </td>
                            <td>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#editarTipoModal"
                                    data-id="{{ $tipo->id }}" data-tipo="{{ $tipo->tipo }}"
                                    data-color="{{ $tipo->color }}" data-color="{{ $tipo->color }}"><i
                                        class="fas fa-edit "></i></button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarTipoModal"
                                    data-id="{{ $tipo->id }}"><i class="fas fa-trash"></i></button>
                            </td>



                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pagination">
                {{ $tipos->links() }}
            </div>
        </div>
    </div>




    <div class="modal" id="crearTipoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Tipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para crear tipo -->
                    <form id="crearTipoForm" action="{{ route('tipo.create') }}" method="post">
                        @csrf
                        <!-- Campos del formulario -->
                        <div class="form-group">
                            <label for="tipo">Tipo:</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="color" class="form-control" id="color" name="color" required>
                        </div>



                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="editarTipoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Tipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para editar tipo -->
                    <form id="editarTipoForm" action="{{ route('tipo.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="editarTipoId" id="editarTipoId">
                        <!-- Campos del formulario -->
                        <div class="form-group">
                            <label for="tipo">Tipo:</label>
                            <input type="text" class="form-control" id="editarTipoTipo" name="tipo" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="color" class="form-control" id="editarTipoColor" name="color" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="eliminarTipoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Eliminar Tipo</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para eliminar Tipo -->
                    <form id="eliminarTipoForm" action="{{ route('tipo.delete') }}" method="post">
                        @method('DELETE')
                        @csrf

                        <input type="hidden" id="eliminarTipoId" name="id">
                        <h4>¿Estás seguro/a de eliminar este Tipo? Esta acción es irreversible</h4>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#editarTipoModal').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget);
                var id = button.data('id');
                var tipo = button.data('tipo');
                var color = button.data('color');

                // Actualizar los campos del formulario con los datos pasados
                $('#editarTipoId').val(id);
                $('#editarTipoTipo').val(tipo);
                $('#editarTipoColor').val(color);
            });
            $('#eliminarTipoModal').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget);
                var id = button.data('id');
                // Actualizar los campos del formulario con los datos pasados
                $('#eliminarTipoId').val(id);

            });


        });
    </script>
@endsection
