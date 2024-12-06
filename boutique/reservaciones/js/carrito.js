// carrito.js

// Funciones para manejar cookies

// Establecer una cookie
function setCookie(nombre, valor, dias) {
    var fecha = new Date();
    fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
    var expiracion = "expires=" + fecha.toUTCString();
    document.cookie = nombre + "=" + encodeURIComponent(valor) + ";" + expiracion + ";path=/";
}

// Obtener el valor de una cookie
function getCookie(nombre) {
    var nombreEQ = nombre + "=";
    var cookiesArray = document.cookie.split(';');
    for (var i = 0; i < cookiesArray.length; i++) {
        var c = cookiesArray[i].trim();
        if (c.indexOf(nombreEQ) === 0) return decodeURIComponent(c.substring(nombreEQ.length, c.length));
    }
    return null;
}

// Eliminar una cookie
function deleteCookie(nombre) {
    document.cookie = nombre + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

// Obtener el carrito desde la cookie
function obtenerCarrito() {
    var carrito = getCookie('carrito');
    return carrito ? JSON.parse(carrito) : [];
}

// Guardar el carrito en la cookie
function guardarCarrito(carrito) {
    setCookie('carrito', JSON.stringify(carrito), 7); // La cookie expira en 7 días
}

// Agregar un producto al carrito
function agregarAlCarrito(idProducto, cantidad) {
    var carrito = obtenerCarrito();

    // Verificar si el producto ya está en el carrito
    var productoEnCarrito = carrito.find(item => item.id === idProducto);
    if (productoEnCarrito) {
        // Actualizar cantidad
        productoEnCarrito.cantidad += cantidad;
    } else {
        // Agregar nuevo producto al carrito
        carrito.push({ id: idProducto, cantidad: cantidad });
    }

    guardarCarrito(carrito);
    mostrarCarrito();
}

// Eliminar un producto del carrito
function eliminarDelCarrito(idProducto) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
        var carrito = obtenerCarrito();
        carrito = carrito.filter(item => item.id !== idProducto);
        guardarCarrito(carrito);
        mostrarCarrito();
    }
}

// Editar la cantidad de un producto en el carrito
function editarCantidad(idProducto, nuevaCantidad) {
    var carrito = obtenerCarrito();
    var productoEnCarrito = carrito.find(item => item.id === idProducto);

    if (productoEnCarrito) {
        // Validar la nueva cantidad
        var maxDisponibles = productos.find(p => p.id === idProducto).disponibles;
        if (isNaN(nuevaCantidad) || nuevaCantidad < 1 || nuevaCantidad > maxDisponibles) {
            alert('Por favor, ingresa una cantidad válida.');
            mostrarCarrito(); // Restaurar la cantidad anterior en la interfaz
            return;
        }

        // Confirmar la acción
        if (confirm(`¿Deseas actualizar la cantidad a ${nuevaCantidad}?`)) {
            productoEnCarrito.cantidad = nuevaCantidad;
            guardarCarrito(carrito);
            mostrarCarrito();
        } else {
            mostrarCarrito(); // Restaurar la cantidad anterior en la interfaz
        }
    }
}

function mostrarCarrito() {
    var carrito = obtenerCarrito();
    var listaCarrito = document.getElementById('lista-carrito');
    listaCarrito.innerHTML = '';

    if (carrito.length === 0) {
        listaCarrito.innerHTML = '<p>El carrito está vacío.</p>';
        return;
    }

    var total = 0;

    carrito.forEach(item => {
        var producto = productos.find(prod => prod.id === item.id);
        var subtotal = producto.precio * item.cantidad;
        total += subtotal;

        var elemento = document.createElement('div');
        elemento.classList.add('item-carrito');
        elemento.innerHTML = `
            <p>${producto.nombre}</p>
            <p>Precio: $${producto.precio}</p>
            <p>Cantidad: 
                <input type="number" class="cantidad-carrito" data-id="${item.id}" value="${item.cantidad}" min="1" max="${producto.disponibles}">
            </p>
            <p>Subtotal: $${subtotal}</p>
            <button class="eliminar-item" data-id="${item.id}">Eliminar</button>
        `;
        listaCarrito.appendChild(elemento);
    });

    // Mostrar el total
    var totalElemento = document.createElement('div');
    totalElemento.classList.add('total-carrito');
    totalElemento.innerHTML = `<h3>Total: $${total}</h3>`;
    listaCarrito.appendChild(totalElemento);

    // Añadir eventos a los botones de eliminar y campos de cantidad
    // ...

    // Añadir eventos a los botones de eliminar
    var botonesEliminar = document.querySelectorAll('.eliminar-item');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function() {
            var idProducto = this.getAttribute('data-id');
            eliminarDelCarrito(idProducto);
        });
    });

    // Añadir eventos a los campos de cantidad
    var camposCantidad = document.querySelectorAll('.cantidad-carrito');
    camposCantidad.forEach(campo => {
        campo.addEventListener('change', function() {
            var idProducto = this.getAttribute('data-id');
            var nuevaCantidad = parseInt(this.value);
            editarCantidad(idProducto, nuevaCantidad);
        });
    });
}

// Finalizar la compra
function finalizarCompra() {
    if (!confirm('¿Estás seguro de que deseas finalizar la compra?')) {
        return;
    }

    var carrito = obtenerCarrito();

    // Simular la finalización de la compra
    //alert('Compra realizada con éxito.');

    // Limpiar el carrito
    deleteCookie('carrito');
    mostrarCarrito();
}
