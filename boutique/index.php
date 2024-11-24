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
	<title>Slider Nav</title>
</head>
<body>
	<!-- Barra de navegación -->
    <nav class="navbar" >
        <a href="#inicio"><img src="img/logo.png" alt=""></a>
        <a class="searcher">
			<form action="">
				<div class="custom-select">
					<select>
						<option value="" disabled selected>Selecciona una opción</option>
						<option value="option1">Opción 1</option>
						<option value="option2">Opción 2</option>
						<option value="option3">Opción 3</option>
					</select>
				</div>
				<input type="text" placeholder="Buscar...">
				<button>Buscar</button>
			</form>
		</a>
        <a href="carrito/carrito.php" class="carro">
			<lord-icon src="https://cdn.lordicon.com/ggirntso.json" trigger="hover" style="width: 60%;height:80%;"></lord-icon>
		</a>
        <a href="sesion/ingreso.php">
			<lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="hover" state="hover-looking-around" colors="primary:#121331,secondary:#109173" style="width:70%;height:80%"></lord-icon>
		</a>
    </nav>

    <!-- Sección principal (Hero) -->
	<div class="hero" id="hero"></div>

    <!-- Menú de navegación secundario -->
	<nav id="menu">
		<a href="#habitaciones">Inicio</a>
		<a href="#servicios">Hoteles</a>
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
				<h1>Hoteles</h1>
				<div class="habitaciones-navegacion">
					<button class="flecha flecha-prev">&#10094;</button> <!-- Flecha izquierda -->
					
					<div class="habitacion-contenedor">
						<!-- Habitaciones -->
						<div class="habitacion active">
							<img src="img/fondo.jpg" alt="Habitación 1">
							<div class="habitacion-info">
								<p class="descripcion">Habitación 1 - Estándar</p>
								<p class="precio">Precio: $100 / noche</p>
								<button class="btn-reservar">Reservar</button>
							</div>
						</div>
						<div class="habitacion">
							<img src="img/fondo.webp" alt="Habitación 2">
							<div class="habitacion-info">
								<p class="descripcion">Habitación 2 - Suite</p>
								<p class="precio">Precio: $150 / noche</p>
								<button class="btn-reservar">Reservar</button>
							</div>
						</div>
						<div class="habitacion">
							<img src="img/example.webp" alt="Habitación 3">
							<div class="habitacion-info">
								<p class="descripcion">Habitación 3 - Deluxe</p>
								<p class="precio">Precio: $200 / noche</p>
								<button class="btn-reservar">Reservar</button>
							</div>
						</div>
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
							<img src="https://hips.hearstapps.com/hmg-prod/images/piscina-higueron-resort-1658313893.jpg?crop=0.6666666666666666xw:1xh;center,top&resize=980:*" alt="Piscina">
							<h3>Piscina</h3>
							<p>Piscina de lujo con área de descanso.</p>
						</div>
						<div class="amenity">
							<img src="https://cms.hotelmousai.com/cms/resources/header/spa-imagine-hotel-mousai-s-w414h414.webp" alt="Spa">
							<h3>Spa</h3>
							<p>Relájate con nuestro servicio de spa.</p>
						</div>
						<div class="amenity">
							<img src="https://smartguests.com/images/product/Hotel_Wifi_Password_Cards69.png" alt="WiFi">
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
							<p>"¡Un lugar maravilloso! Las amenidades y el servicio son increíbles. Me siento como en casa."</p>
							<h4>- Juan Pérez</h4>
						</div>
						<div class="testimonial">
							<p>"La experiencia ha sido excelente. Las instalaciones están bien cuidadas y el personal es amable."</p>
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

	<!-- Scripts -->
	<script src="js/app.js"></script>
	<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>