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
        events: '/event/get',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        dateClick: function (info) {
            var fechaFormateada = info.date.toISOString().slice(0, 16);
            var endFormatted = new Date(info.date);
            endFormatted.setDate(endFormatted.getDate() + 1);
            endFormatted = endFormatted.toISOString().slice(0, 16);
            mostrarModal('Agregar Evento', {
                start: fechaFormateada,
                end: endFormatted,
                route: 'c',
            });
        },
        eventClick: function (info) {
            console.log(info)
            var start = info.event.start.toISOString().slice(0, 16);
            var end = info.event.end.toISOString().slice(0, 16);
            mostrarModal('Editar Evento', {
                id: info.event.id,
                title: info.event.title,
                start: start,
                end: end,
                tipo: info.event.extendedProps.tipoId,
                route: 'edit',
            });
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
        console.log(datosEvento)
        // Lógica para mostrar la ventana modal y completar el formulario con datosEvento
        $('#eventModalLabel').text(titulo);
        $('#title').val(datosEvento.title);
        $('#start').val(datosEvento.start);
        $('#end').val(datosEvento.end );
        $('#tipo').val(datosEvento.tipo);
        $('#id').val(datosEvento.id);
        var action = '';
        if(datosEvento.route == 'c') action = '/event/create';
        else action = '/event/update';
        $('#eventForm').attr("action", action )


        $('#btnConfirmarBorrar').on('click', () => {
            var id = datosEvento.id
            cerrarModal();
            abrirConfirmarModal(id);
        })

        // Configuración de los botones del modal
        $('#guardarEvento').off('click').on('click', function () {
            guardarEvento(datosEvento);
            cerrarModal();

        });

        $('#eventModal').modal('show');
        $('#cerrarModal').on('click', function () {
            cerrarModal();
        });
    }

    function cerrarModal() {
        $('#eventModal').modal('hide');
    }
    function abrirConfirmarModal(id) {
        $('#confirmarBorrar').modal('show');
        $('#destroyEventId').val(id);
    };


});


