@extends('adminlte::page')

@section('title', 'Listado de Usuarios')

@section('content_header')
    <h1>
        <i class="fa fa-users"></i> Listado de Usuarios
    </h1>
    <hr>
@endsection

@section('content')
@if (session('success'))
        <div class="m-3 bg-success rounded text-center">
            <h3 class="text-light">{{session('success')}}</h3>
        </div>
    @endif
    <div class="row d-flex justify-between">
        <div class="col">

            <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#crearUsuarioModal"><i
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Activado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->active)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-cross text-danger"></i>
                                @endif
                            </td>
                            <td><button class="btn btn-primary" data-toggle="modal" data-target="#editarUsuarioModal"
                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"><i class="fas fa-edit "></i></button>
                                @if ($user->id != Auth::user()->id)
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuarioModal"
                                        data-id="{{ $user->id }}"><i class="fas fa-trash"></i></button>

                            </td>
                    @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <div class="modal" id="eliminarUsuarioModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Eliminar Usuario</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para crear usuario -->
                    <form id="eliminarUsuarioForm" action="{{ route('user.destroy') }}" method="post">
                        @method('DELETE')
                        @csrf

                        <input type="hidden" id="destroyUserId" name="id">
                        <h4>¿Estás seguro/a de eliminar este usuario? Esta acción es irreversible</h4>

                        <div class="col-12 d-flex justify-content-between ">
                            <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="editarUsuarioModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para crear usuario -->
                    <form id="editarUsuarioForm" action="{{ route('user.update') }}" method="post">
                        @csrf
                        <!-- Campos del formulario -->
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <input type="hidden" id="editUserId" name="id">
                        <div class="form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>


                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="crearUsuarioModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario para crear usuario -->
                    <form id="crearUsuarioForm" action="{{ route('user.create') }}" method="post">
                        @csrf
                        <!-- Campos del formulario -->
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña:</label>
                            <input type="password"class="form-control" name="password_confirmation"
                                id="password_confirmation" required>
                        </div>


                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var editarUsuarioModal = document.getElementById('editarUsuarioModal');
            var crearUsuarioForm = document.querySelector('#crearUsuarioForm');
            var eliminarUsuarioForm = document.querySelector('#eliminarUsuarioForm');

            $('#eliminarUsuarioModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                // Actualizar los campos del formulario con los datos pasados
                $('#destroyUserId').val(id);
            });


            $('#editarUsuarioModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var email = button.data('email');

                // Actualizar los campos del formulario con los datos pasados
                $('#editUserId').val(id);
                $('#editUserName').val(name);
                $('#editUserEmail').val(email);
            });



            crearUsuarioForm.addEventListener('submit', function(event) {
                var password = document.getElementById('password').value;
                var password_confirmation = document.getElementById('password_confirmation').value;



                // Verificar si las contraseñas coinciden
                if (password !== password_confirmation) {
                    event.preventDefault();
                    alert("Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
                    return;
                } else crearUsuarioForm.submit();



            });


        });



        function loadUsers() {
            var perPage = document.getElementById('per_page').value;

            fetch('/users?per_page=' + perPage)
                .then(response => response.text())
                .then(data => {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(data, 'text/html');
                    var tableBody = doc.getElementById('user-table').getElementsByTagName('tbody')[0];
                    var paginationLinks = doc.getElementById('pagination-links').innerHTML;

                    document.getElementById('user-table').getElementsByTagName('tbody')[0].innerHTML =
                        tableBody.innerHTML;
                    document.getElementById('pagination-links').innerHTML = paginationLinks;
                })
                .catch(error => {
                    console.error('Error al cargar usuarios: ', error);
                });
        }
    </script>



@endsection
