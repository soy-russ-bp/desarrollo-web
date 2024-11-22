document.addEventListener('DOMContentLoaded', () => {
    cargarHabitaciones();
    document.getElementById('agregar-habitacion').addEventListener('click', abrirModalAgregar);
    document.querySelector('.cerrar-modal').addEventListener('click', cerrarModal);
    document.getElementById('form-habitacion').addEventListener('submit', guardarHabitacion);
});

let habitaciones = obtenerHabitaciones();

function cargarHabitaciones() {
    const tbody = document.querySelector('#tabla-habitaciones tbody');
    tbody.innerHTML = '';

    habitaciones.forEach(habitacion => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${habitacion.id}</td>
            <td>${habitacion.nombre}</td>
            <td>$${habitacion.precio}</td>
            <td>${habitacion.disponibles}</td>
            <td>${habitacion.categoria}</td>
            <td><img src="${habitacion.imagen}" alt="${habitacion.nombre}" width="50"></td>
            <td>
                <button class="editar" data-id="${habitacion.id}">Editar</button>
                <button class="eliminar" data-id="${habitacion.id}">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Eventos de edición y eliminación
    document.querySelectorAll('.editar').forEach(boton => {
        boton.addEventListener('click', abrirModalEditar);
    });

    document.querySelectorAll('.eliminar').forEach(boton => {
        boton.addEventListener('click', eliminarHabitacion);
    });
}

function abrirModalAgregar() {
    document.getElementById('modal-titulo').textContent = 'Agregar Habitación';
    document.getElementById('form-habitacion').reset();
    document.getElementById('habitacion-id').value = '';
    document.getElementById('modal-habitacion').style.display = 'block';
}

function abrirModalEditar() {
    const id = this.getAttribute('data-id');
    const habitacion = habitaciones.find(h => h.id === id);

    document.getElementById('modal-titulo').textContent = 'Editar Habitación';
    document.getElementById('habitacion-id').value = habitacion.id;
    document.getElementById('nombre').value = habitacion.nombre;
    document.getElementById('precio').value = habitacion.precio;
    document.getElementById('disponibles').value = habitacion.disponibles;
    document.getElementById('categoria').value = habitacion.categoria;
    document.getElementById('descripcion').value = habitacion.descripcion;
    document.getElementById('modal-habitacion').style.display = 'block';
}

function cerrarModal() {
    document.getElementById('modal-habitacion').style.display = 'none';
}

function guardarHabitacion(e) {
    e.preventDefault();

    const id = document.getElementById('habitacion-id').value;
    const nombre = document.getElementById('nombre').value;
    const precio = parseFloat(document.getElementById('precio').value);
    const disponibles = parseInt(document.getElementById('disponibles').value);
    const categoria = document.getElementById('categoria').value;
    const descripcion = document.getElementById('descripcion').value;
    const imagenInput = document.getElementById('imagen');
    let imagen = '';

    if (imagenInput.files && imagenInput.files[0]) {
        // Supongamos que guardamos la imagen localmente por simplicidad
        imagen = URL.createObjectURL(imagenInput.files[0]);
    } else if (id) {
        // Si estamos editando y no se selecciona una nueva imagen
        imagen = habitaciones.find(h => h.id === id).imagen;
    }

    if (id) {
        // Editar habitación existente
        const index = habitaciones.findIndex(h => h.id === id);
        habitaciones[index] = { id, nombre, precio, disponibles, categoria, descripcion, imagen };
    } else {
        // Agregar nueva habitación
        const nuevoId = generarIdUnico();
        habitaciones.push({ id: nuevoId, nombre, precio, disponibles, categoria, descripcion, imagen });
    }

    guardarHabitaciones();
    cargarHabitaciones();
    cerrarModal();
}

function eliminarHabitacion() {
    const id = this.getAttribute('data-id');
    if (confirm('¿Estás seguro de que deseas eliminar esta habitación?')) {
        habitaciones = habitaciones.filter(h => h.id !== id);
        guardarHabitaciones();
        cargarHabitaciones();
    }
}

// Funciones para manejar el almacenamiento local de habitaciones
function obtenerHabitaciones() {
    const habitacionesStorage = localStorage.getItem('habitaciones');
    return habitacionesStorage ? JSON.parse(habitacionesStorage) : [];
}

function guardarHabitaciones() {
    localStorage.setItem('habitaciones', JSON.stringify(habitaciones));
}

function generarIdUnico() {
    return Date.now().toString();
}
