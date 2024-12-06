// js/carrito.js

document.addEventListener('DOMContentLoaded', function() {
    // Función para obtener una cookie por su nombre
    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i=0;i < ca.length;i++) {
            let c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length,c.length));
        }
        return null;
    }

    // Función para establecer una cookie
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
    }

    // Función para obtener el carrito desde las cookies
    function getCart() {
        let cart = getCookie('carrito');
        return cart ? JSON.parse(cart) : [];
    }

    // Función para guardar el carrito en las cookies
    function saveCart(cart) {
        setCookie('carrito', JSON.stringify(cart), 7); // Expira en 7 días
    }

    // Función para agregar un artículo al carrito
    function addToCart(id, tipo, precio) {
        let cart = getCart();
        let existingItem = cart.find(item => item.id_habitacion === id);
        if (existingItem) {
            existingItem.cantidad += 1;
        } else {
            cart.push({
                id_habitacion: id,
                tipo: tipo,
                precio: parseFloat(precio),
                cantidad: 1
            });
        }
        saveCart(cart);
        updateCartIcon();
        alert('Habitación agregada al carrito.');
    }

    // Función para actualizar el icono del carrito con la cantidad de artículos
    function updateCartIcon() {
        let cart = getCart();
        let count = cart.reduce((sum, item) => sum + item.cantidad, 0);
        let cartIcon = document.getElementById('cantidad-carrito');
        if (cartIcon) {
            cartIcon.textContent = count;
        }
    }

    // Asignar eventos a los botones "Reservar"
    let reservarButtons = document.querySelectorAll('.btn-reservar');
    reservarButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let tipo = this.getAttribute('data-tipo');
            let precio = this.getAttribute('data-precio');
            addToCart(id, tipo, precio);
        });
    });

    // Inicializar el icono del carrito al cargar la página
    updateCartIcon();
});
