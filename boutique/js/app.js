(function () {
    function fetchRoomDetails(roomId) {
        console.log(`Fetching details for room ID: ${roomId}`);
        const popup = document.getElementById(`popup-${roomId}`);
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `Habitaciones/ListarHabitaciones.php?id=${roomId}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                popup.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    // Exponer la función al contexto global
    window.fetchRoomDetails = fetchRoomDetails;
})();

const menu = document.getElementById('menu');
const indicador = document.getElementById('indicador');
const secciones = document.querySelectorAll('.seccion');

let tamañoIndicador = menu.querySelector('a').offsetWidth;
indicador.style.width = tamañoIndicador + 'px';

let indexSeccionActiva;

// Observer
const observer = new IntersectionObserver((entradas, observer) => {
	entradas.forEach(entrada => {
		if(entrada.isIntersecting){
			// Obtenemos cual es la seccion que esta entrando en pantalla.
			// console.log(`La entrada ${entrada.target.id} esta intersectando`);

			// Creamos un arreglo con las secciones y luego obtenemos el index del la seccion que esta en pantalla.
			indexSeccionActiva = [...secciones].indexOf(entrada.target);
			indicador.style.transform = `translateX(${tamañoIndicador * indexSeccionActiva}px)`;
		}
	});
}, {
	rootMargin: '-80px 0px 0px 0px',
	threshold: 0.2
});

// Agregamos un observador para el hero.
const hero = document.getElementById('hero');
if (hero) {
    observer.observe(hero);
}

// Asignamos un observador a cada una de las secciones
secciones.forEach(seccion => {
    if (seccion) {
        observer.observe(seccion);
    }
});

// Evento para cuando la pantalla cambie de tamaño.
const onResize = () => {
	// Calculamos el nuevo tamaño que deberia tener el indicador.
	tamañoIndicador = menu.querySelector('a').offsetWidth;

	// Cambiamos el tamaño del indicador.
	indicador.style.width = `${tamañoIndicador}px`;

	// Volvemos a posicionar el indicador.
	indicador.style.transform = `translateX(${tamañoIndicador * indexSeccionActiva}px)`;
}

window.addEventListener('resize', onResize);

////////////////////////////////////////////////////////////////////////////////
let habitacionActual = 0;
const habitaciones = document.querySelectorAll('.habitacion');

function mostrarHabitacion(direccion) {
    // Quitar la clase 'active' de la habitación actual para ocultarla
    habitaciones[habitacionActual].classList.remove('active');

    // Calcular el índice de la siguiente habitación
    if (direccion === 'next') {
        habitacionActual = (habitacionActual + 1) % habitaciones.length;
    } else if (direccion === 'prev') {
        habitacionActual = (habitacionActual - 1 + habitaciones.length) % habitaciones.length;
    }

    // Añadir la clase 'active' a la nueva habitación
    habitaciones[habitacionActual].classList.add('active');
}

// Mostrar la primera habitación al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    habitaciones[habitacionActual].classList.add('active');

    // Agregar eventos a las flechas
    document.querySelector('.flecha-prev').addEventListener('click', () => mostrarHabitacion('prev'));
    document.querySelector('.flecha-next').addEventListener('click', () => mostrarHabitacion('next'));
});

//AMENIDADES
document.querySelectorAll('.amenity').forEach(item => {
    item.addEventListener('click', () => {
        alert("¡Más información sobre esta amenidad próximamente!");
    });
});

//testimoniosss

let currentTestimonial = 0;
const testimonials = document.querySelectorAll('.testimonial');

function nextTestimonial() {
    testimonials[currentTestimonial].classList.remove('active');
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    testimonials[currentTestimonial].classList.add('active');
}



function showMore() {
    alert("Descubre nuestro compromiso con el confort y la excelencia.");
}


let currentIndex = 0;
const slides = document.querySelectorAll('.slider');

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === index) {
            slide.classList.add('active');
        }
    });
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

// Inicializa el slider con la primera imagen
showSlide(currentIndex);

// Cambia de imagen cada 5 segundos
setInterval(nextSlide, 5000);

// Función para el botón "Explorar"
function exploreHotel() {
    alert("¡Explora más sobre nuestras habitaciones y servicios!");
    // Aquí puedes agregar lógica adicional si deseas
}

