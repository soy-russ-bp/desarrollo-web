<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'GestorBaseDatos.php';
session_start();

try {
	// Abrir conexión a la base de datos
	$conexion = abrirConexion();
	// Obtener todas las habitaciones
	$habitaciones = listarHabitaciones($conexion);
	// Cerrar conexión
	cerrarConexion($conexion);
} catch (Exception $e) {
	// En caso de error, registrar y asignar un array vacío
	error_log($e->getMessage());
	$habitaciones = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style/navigator.css">
	<link rel="stylesheet" href="style/general.css">
	<link rel="stylesheet" href="style/font-section.css">
	<link rel="stylesheet" href="style/content.css">
	<link rel="stylesheet" href="style/content-home.css">
	<link rel="stylesheet" href="style/content-services.css">
	<link rel="stylesheet" href="style/content-amenities.css">
	<link rel="stylesheet" href="style/content-testimonial.css">
	<title>Hotel Boutique</title>
	<style>
		.seccion .card {
			height: auto;

		}

		.habitacion img {
			width: 100%;
			height: 200px;
			/* Ajusta la altura a tus necesidades */
			object-fit: cover;
			/* Cambiado de fill a cover */
			border-top-left-radius: 8px;
			border-top-right-radius: 8px;
		}

		.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 900px;
    border-radius: 8px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

label {
    display: block;
    margin-top: 10px;
}

input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    box-sizing: border-box;
}

button[type="submit"] {
    
    padding: 10px 20px;
    background-color: #109173;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0d7a63;
}
	</style>
</head>

<body>
	<!-- Barra de navegación -->
	<nav class="navbar">
		<a href="#inicio"><img src="img/logo.png" alt=""></a>
		
		<!-- si es usuario mostrar el buscador, sino, dejarlo gris-->
		

		<?php
		if (isset($_SESSION['tipo_usuario'])) {
			echo "
			<a class='searcher'>
				<form action='buscar.php' method='GET'>
					<div class='custom-select'>
						<select id='tipo' name='tipo'>
							<option value='' selected>Categoria</option>
							<option value='Sencilla'>Sencilla</option>
							<option value='Doble'>Doble</option>
							<option value='Deluxe'>Deluxe</option>
							<option value='Ejecutiva'>Ejecutiva</option>
							<option value='Presidencial'>Presidencial</option>
						</select>
					</div>
					<input type='text' name='keywords' placeholder='Buscar...'
					value='" . (isset($_GET['keywords']) ? htmlspecialchars($_GET['keywords']) : "") . "'>
					<button type='submit'>Buscar</button>
				</form>
			</a>
			";

		} else {
			echo "<p style='color: gray;'>Buscador no disponible, inicia sesión</p>";
		}
		?>



		<!-- si es Huesped registrado mostrar el carrito, sino, no mostrar nada-->
		<?php
		if (isset($_SESSION['tipo_usuario'])) {

			if ($_SESSION['tipo_usuario'] == 'Huesped') {
				echo "<a href='reservaciones/carrito.php' class='carro'>
						<lord-icon src='https://cdn.lordicon.com/ggirntso.json' trigger='hover' style='width: 60%; height:80%;'></lord-icon>
					</a>";
			} elseif ($_SESSION['tipo_usuario'] == 'Administrador') {
				echo "<a href='admin/admin.php' class='admin-panel'>
						<lord-icon src='https://cdn.lordicon.com/exymduqj.json' trigger='hover' style='width: 60%; height:80%;'></lord-icon>
					</a>";
			}
		} else {
			// Si no hay sesión activa, no mostrar algo
			echo " ";
		}
		?>

		<!-- si no hay una sesion iniciada dirigir a iniciar sesion, si sí hay, dirigir a cerrar sesión -->
        <a href="sesion/ingreso.php">
			<lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="hover" state="hover-looking-around" colors="primary:#121331,secondary:#109173" style="width:70%;height:80%"></lord-icon>
		</a>

	</nav>

	<!-- Sección principal (Hero) -->
	<div class="hero" id="hero"></div>

	<!-- Menú de navegación secundario -->
	<nav id="menu">
		<a href="#habitaciones">Inicio</a>
		<a href="#servicios">Habitaciones</a>
		<a href="#galeria">Amenidades</a>
		<a href="#contacto">Testimonios</a>
		<span class="indicador" id="indicador"></span>
	</nav>

	<!-- Sección de contenido -->
	<div class="secciones">
		<!-- Sección de DESCRIPCION O INICIO -->
		<div class="seccion" id="habitaciones">
			<div class="card">
				<div class="inicio">
					<div class="slider">

					</div>
					<div class="contenido">
						<h1>Bienvenido a Nuestro Hotel Boutique</h1>
						<p>Disfruta de una estancia inolvidable con nosotros.</p>
						<button onclick="exploreHotel()">Explorar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Sección de servicios -->
		<div class="seccion" id="servicios">
			<div class="card" class="card-container">
				<h1>Habitaciones</h1>
				<div class="habitaciones-navegacion">
					<button class="flecha flecha-prev">&#10094;</button> <!-- Flecha izquierda -->

					<div class="habitacion-contenedor">
						<?php if (!empty($habitaciones)): ?>
							<?php foreach ($habitaciones as $index => $habitacion): ?>
								<div class="habitacion <?php echo $index === 0 ? 'active' : ''; ?>">
									<img src="Habitaciones/imagenes/<?php echo htmlspecialchars($habitacion['imagen']); ?>"
										alt="Habitación <?php echo htmlspecialchars($habitacion['id_habitacion']); ?>">
									<div class="habitacion-info">
										<p class="descripcion"><?php echo htmlspecialchars($habitacion['tipo']); ?></p>
										<p class="precio">Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?> /
											noche</p>
										<button class="btn-reservar">Reservar</button>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<p>No hay habitaciones disponibles en este momento.</p>
						<?php endif; ?>
					</div>

					<button class="flecha flecha-next">&#10095;</button> <!-- Flecha derecha -->
				</div>
			</div>
		</div>

		<!-- Sección de galería -->
		<div class="seccion" id="galeria">
			<div class="card">
				<section class="amenities">
					<h2>Amenidades</h2>
					<div class="amenity-list">
						<div class="amenity">
							<img src="https://pictures.smartfit.com.br/5959/big/IMG_5063.jpg?1550700787" alt="Gimnasio">
							<h3>Gimnasio</h3>
							<p>Equipado con lo último en maquinaria.</p>
						</div>
						<div class="amenity">
							<img src="https://hips.hearstapps.com/hmg-prod/images/piscina-higueron-resort-1658313893.jpg?crop=0.6666666666666666xw:1xh;center,top&resize=980:*"
								alt="Piscina">
							<h3>Piscina</h3>
							<p>Piscina de lujo con área de descanso.</p>
						</div>
						<div class="amenity">
							<img src="https://cms.hotelmousai.com/cms/resources/header/spa-imagine-hotel-mousai-s-w414h414.webp"
								alt="Spa">
							<h3>Spa</h3>
							<p>Relájate con nuestro servicio de spa.</p>
						</div>
						<div class="amenity">
							<img src="https://smartguests.com/images/product/Hotel_Wifi_Password_Cards69.png"
								alt="WiFi">
							<h3>WiFi Gratis</h3>
							<p>Conexión de alta velocidad en todo el edificio.</p>
						</div>
					</div>
				</section>
			</div>
		</div>

		<!-- Sección de testimonios -->
		<div class="seccion" id="contacto">
			<div class="card test-container">
				<section class="testimonials-section">
					<h2>Testimonios</h2>
					<div class="testimonials-container">
						<div class="testimonial active">
							<p>"¡Un lugar maravilloso! Las amenidades y el servicio son increíbles. Me siento como en
								casa."</p>
							<h4>- Juan Pérez</h4>
						</div>
						<div class="testimonial">
							<p>"La experiencia ha sido excelente. Las instalaciones están bien cuidadas y el personal es
								amable."</p>
							<h4>- María López</h4>
						</div>
						<div class="testimonial">
							<p>"Realmente disfruto de la tranquilidad y el ambiente. Lo recomendaría a cualquiera."</p>
							<h4>- Fer Martinez</h4>
						</div>
					</div>
					<button onclick="nextTestimonial()">Siguiente Testimonio</button>
				</section>
			</div>
		</div>
	</div>

	<div id="modalReservacion" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Confirmar Reservación</h2>
        <form action="confirmarReservacion.php" method="POST">
            <input type="hidden" name="id_habitacion" id="id_habitacion" value="">
            
            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="date" id="fecha_entrada" name="fecha_entrada" required>
            
            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="date" id="fecha_salida" name="fecha_salida" required>
            
            <label for="cantidad">Cantidad de Habitaciones:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" value="1" required>
            
            <button type="submit">Confirmar Reservación</button>
        </form>
    </div>
</div>

	<!-- Scripts -->
	<script>
// Obtener el modal
var modal = document.getElementById("modalReservacion");

// Obtener todos los botones de reservar
var botonesReservar = document.getElementsByClassName("btn-reservar");

// Obtener el elemento <span> que cierra el modal
var span = document.getElementsByClassName("close")[0];

// Cuando el usuario hace clic en un botón de reservar, abre el modal y establece el ID de la habitación
for (var i = 0; i < botonesReservar.length; i++) {
    botonesReservar[i].onclick = function() {
        var idHabitacion = this.parentElement.parentElement.querySelector('img').getAttribute('alt').split(' ')[1]; // Asumiendo que el alt tiene 'Habitación {id}'
        document.getElementById("id_habitacion").value = idHabitacion;
        modal.style.display = "block";
    }
}

// Cuando el usuario hace clic en <span> (x), cierra el modal
span.onclick = function() {
    modal.style.display = "none";
}

// Cuando el usuario hace clic fuera del modal, lo cierra
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
	<script src="js/app.js"></script>
	<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>