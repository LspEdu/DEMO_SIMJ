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
                    <form id="eventForm">
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
