import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';



document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        themeSystem: 'bootstrap',
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: '/events',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        dateClick: function (info) {
            mostrarModal('Agregar Evento', {
                start: info.dateStr,
                end: info.dateStr,
            });
        },
        eventClick: function (info) {
            mostrarModal('Editar Evento', info.event);
        },
        selectable: true,
        select: function (info) {
            mostrarModal('Agregar Evento', {
                start: info.startStr,
                end: info.endStr,
            });
            calendar.unselect(); // Deseleccionar el rango después de mostrar el modal
        },
    });

    calendar.render();

    function mostrarModal(titulo, datosEvento) {
        // Lógica para mostrar la ventana modal y completar el formulario con datosEvento
        $('#eventModalLabel').text(titulo);
        $('#title').val(datosEvento.title || '');
        $('#start').val(datosEvento.start ? datosEvento.start.toISOString().slice(0, -8) : '');
        $('#end').val(datosEvento.end ? datosEvento.end.toISOString().slice(0, -8) : '');

        // Configuración de los botones del modal
        $('#guardarEvento').off('click').on('click', function () {
            guardarEvento(datosEvento);
            cerrarModal();
        });

        $('#eliminarEvento').off('click').on('click', function () {
            eliminarEvento(datosEvento);
            cerrarModal();
        });

        $('#eventModal').modal('show');
    }

    function cerrarModal() {
        $('#eventModal').modal('hide');
    }

    function guardarEvento(datosEvento) {
        // Lógica para guardar el evento en la base de datos
        // Puedes enviar los datos al servidor mediante una solicitud AJAX
        // Ejemplo AJAX (requiere jQuery):
        /*
        $.ajax({
            method: 'POST',
            url: '/events', // Ruta para guardar eventos en el servidor
            data: {
                title: $('#title').val(),
                start: $('#start').val(),
                end: $('#end').val(),
            },
            success: function (response) {
                // Lógica después de guardar exitosamente
                console.log(response);
            },
            error: function (error) {
                // Lógica en caso de error
                console.error(error);
            }
        });
        */
    }

    function eliminarEvento(datosEvento) {
        // Lógica para eliminar el evento de la base de datos
        // Puedes enviar los datos al servidor mediante una solicitud AJAX
        // Ejemplo AJAX (requiere jQuery):
        /*
        $.ajax({
            method: 'DELETE',
            url: '/events/' + datosEvento.id, // Ruta para eliminar eventos en el servidor
            success: function (response) {
                // Lógica después de eliminar exitosamente
                console.log(response);
            },
            error: function (error) {
                // Lógica en caso de error
                console.error(error);
            }
        });
        */
    }
});


