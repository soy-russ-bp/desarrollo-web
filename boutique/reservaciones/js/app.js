// app.js

document.addEventListener('DOMContentLoaded', () => {
    mostrarProductos();
    mostrarCarrito();

    // Evento para finalizar la compra
    document.getElementById('finalizar-compra').addEventListener('click', finalizarCompra);
});

// Mostrar los productos en la página
function mostrarProductos() {
    const contenedorProductos = document.getElementById('productos');
    contenedorProductos.innerHTML = '';

    // Obtener categorías únicas
    const categorias = [...new Set(productos.map(producto => producto.categoria))];

    categorias.forEach(categoria => {
        const tituloCategoria = document.createElement('h2');
        tituloCategoria.textContent = categoria;
        tituloCategoria.classList.add('titulo-categoria');
        contenedorProductos.appendChild(tituloCategoria);

        const contenedorCategoria = document.createElement('div');
        contenedorCategoria.classList.add('contenedor-categoria');

        productos.filter(producto => producto.categoria === categoria)
            .forEach(producto => {
                const elemento = document.createElement('div');
                elemento.classList.add('producto');
                elemento.innerHTML = `
                    <h3>${producto.nombre}</h3>
                    <img src="${producto.imagen}" alt="${producto.nombre}" width="200">
                    <p>Precio: $${producto.precio}</p>
                    <label for="cantidad-${producto.id}">Cantidad:</label>
                    <input type="number" id="cantidad-${producto.id}" name="cantidad-${producto.id}" value="1" min="1" max="${producto.disponibles}">
                    <button class="agregar-carrito" data-id="${producto.id}">Agregar al Carrito</button>
                    <button class="ver-detalles" data-id="${producto.id}">Ver Detalles</button>
                `;
                contenedorCategoria.appendChild(elemento);
            });

        contenedorProductos.appendChild(contenedorCategoria);
    });


    // Añadir eventos a los botones de agregar al carrito
    var botonesAgregar = document.querySelectorAll('.agregar-carrito');
    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', function () {
            var idProducto = this.getAttribute('data-id');
            var cantidadInput = document.getElementById(`cantidad-${idProducto}`);
            var cantidad = parseInt(cantidadInput.value);

            // Validar la cantidad
            var maxDisponibles = productos.find(p => p.id === idProducto).disponibles;
            if (isNaN(cantidad) || cantidad < 1 || cantidad > maxDisponibles) {
                alert('Por favor, ingresa una cantidad válida.');
                return;
            }

            // Confirmar la acción
            if (confirm(`¿Deseas agregar ${cantidad} ${productos.find(p => p.id === idProducto).nombre}(s) al carrito?`)) {
                agregarAlCarrito(idProducto, cantidad);
            }
        });
    });

    // Añadir eventos a los botones de ver detalles
    var botonesDetalles = document.querySelectorAll('.ver-detalles');
    botonesDetalles.forEach(boton => {
        boton.addEventListener('click', function () {
            var idProducto = this.getAttribute('data-id');
            mostrarDetallesProducto(idProducto);
        });
    });
}

// Función para mostrar los detalles de un producto en una ventana emergente
function mostrarDetallesProducto(idProducto) {
    var producto = productos.find(p => p.id === idProducto);
    var contenido = `
        <h2>${producto.nombre}</h2>
        <img src="${producto.imagen}" alt="${producto.nombre}" width="300">
        <p>${producto.descripcion}</p>
        <p>Precio por noche: $${producto.precio}</p>
        <p>Habitaciones disponibles: ${producto.disponibles}</p>
    `;
    abrirVentanaEmergente(contenido);
}

// Función para abrir una ventana emergente con contenido personalizado
function abrirVentanaEmergente(contenido) {
    // Crear el fondo semitransparente
    var overlay = document.createElement('div');
    overlay.id = 'overlay';
    overlay.innerHTML = `
        <div id="ventana-emergente">
            ${contenido}
            <button id="cerrar-ventana">Cerrar</button>
        </div>
    `;
    document.body.appendChild(overlay);

    // Añadir evento para cerrar la ventana
    document.getElementById('cerrar-ventana').addEventListener('click', function () {
        document.body.removeChild(overlay);
    });
}
const finalizarCompraBtn = document.getElementById('finalizar-compra');
const carritoSection = document.getElementById('carrito');
const pagoSection = document.getElementById('pago');

finalizarCompraBtn.addEventListener('click', () => {
    // Ocultar la sección del carrito
    carritoSection.style.display = 'none';

    // Mostrar la sección de pago
    pagoSection.style.display = 'block';

    // Desplazarse suavemente a la sección de pago
    pagoSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
});

const form = document.getElementById('paymentForm');
const message = document.getElementById('message');
const cardInputs = document.querySelectorAll('.card-input');

cardInputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
        if (e.target.value.length === 4 && index < cardInputs.length - 1) {
            cardInputs[index + 1].focus();
        }
    });
});

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const cardNumber = Array.from(cardInputs).map(input => input.value.trim()).join('');
    const expireDate = document.getElementById('expiraDate').value.trim();
    const cvv = document.getElementById('cvv').value.trim();

    if (cardNumber.length !== 16 || isNaN(cardNumber)) {
        message.textContent = 'Error: El número de tarjeta debe tener 16 dígitos.';
        message.className = 'message error';
        return;
    }

    if (expireDate.length !== 4 || isNaN(expireDate)) {
        message.textContent = 'Error: La fecha de vencimiento debe tener exactamente 4 dígitos (MMYY).';
        message.className = 'message error';
        return;
    }

    if (cvv.length !== 3 || isNaN(cvv)) {
        message.textContent = 'Error: El CVV debe tener exactamente 3 dígitos.';
        message.className = 'message error';
        return;
    }

    message.textContent = 'Pago exitoso';
    message.className = 'message success';

    setTimeout(function () {
        window.location.href = "carrito.php";
    }, 3000);
});
