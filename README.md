# Proyecto de Gestión de Reservaciones para Hotel Boutique

Este proyecto consiste en el desarrollo de una aplicación web para la gestión de reservaciones en un hotel boutique, se divide en 3 usuarios: Administrador, usuario registrado y usuario sin registro.


---

# División de Tareas

## Base de Datos
**Responsable: `Luis Montero`**

### Tareas
1. **Diseño de la base de datos**:
   - Crear el modelo entidad-relación para las tablas necesarias: `usuarios`, `habitaciones`, `reservaciones`, `carrito`, `categorías`, etc.
   - Implementar relaciones entre tablas y restricciones según el modelo relacional.
2. **Implementación de la base de datos**:
   - Crear y configurar las tablas en MariaDB (utilizando XAMPP).
   - Asegurar que los datos estén normalizados para evitar redundancias.
3. **Consultas SQL**:
   - Escribir consultas SQL para búsquedas, reportes, y operaciones de reserva.
4. **Manejo de transacciones**:
   - Implementar transacciones para asegurar la consistencia en operaciones críticas, como las reservaciones.
5. **Mantenimiento**:
   - Optimizar la base de datos para mejorar el rendimiento de las consultas.


---
## Servidor

**Responsables: `Russel` y `Xavi`**

### Tareas de `Russel`
1. **Configuración del servidor y autenticación**:
   - Configurar el entorno de servidor utilizando PHP
   - Desarrollar la autenticación de usuarios con sesiones HTTP.
   - Implementar mensajes de error en caso de inicio de sesión fallido.
2. **Gestión de roles y control de acceso**:
   - Validar roles (administrador, huésped registrado, prospecto) y restringir acceso a páginas protegidas.
   - Restringir el acceso a páginas protegidas según el tipo de usuario.
3. **Cierre de sesión**:
   - Desarrollar el proceso para cerrar sesiones activas de manera segura.

### Tareas de `Xavi`: Administración de reservaciones

1. **Descuento de habitaciones disponibles**:
   - Descontar de la base de datos el número de habitaciones disponibles correspondiente a los tipos de cuartos reservados, una vez que se haya efectuado el pago
3. **Sistema de búsquedas**:
   - Implementar un sistema de búsqueda para habitaciones y servicios, y devolver el resultado.

### Tareas de ... (Admin)
1. **Agregar o dar de alta una habitación.**
    - Proveer la opción para subir o transferir una o más imágenes alusivas al cuarto.
2. **Editar la información de las habitaciones registradas.**
    - Proveer la opción para subir o transferir una o más imágenes alusivas al cuarto.
3. **Eliminar habitaciones**
4. **Generar listados dinámicos de las habitaciones registradas agrupadas por categorías.**


## Cliente
**Responsables: Integrantes 4, 5 y 6**

### Tareas de Integrante 4: Inicio 
1. **Validación de formularios**:
   - Implementar validación de campos en todos los formularios usando JavaScript (por ejemplo, que la contraseña sea mayor a 8 digitos...).
2. **Confirmación de acciones**:
   - Implementar ventanas de confirmación antes de realizar cualquier acción importante (por ejemplo, agregar o eliminar del carrito).
3. **Ventanas emergentes**:
   - Crear ventanas emergentes que permitan consultar información resumida de cada tipo de habitación.

### Tareas de `Laines`: Admin panel
1. **Interfaz de usuario para el catálogo de habitaciones**:
   - Desarrollar la interfaz para mostrar el catálogo de habitaciones, con funcionalidades para agregar, editar y eliminar habitaciones.
   - Agregar opción de carga y edición de imágenes alusivas a cada habitación.
2. **Listados dinámicos de habitaciones**:
   - Implementar la visualización de habitaciones agrupadas por categorías de forma dinámica.
3. **Manejo del carrito de reservaciones**:
   - Crear la interfaz de usuario para visualizar el carrito de reservaciones, con subtotales y costo total.

### Tareas de `Carlos`: 
1. **Diseño de la interfaz y usabilidad**:
   - Diseñar la interfaz gráfica general de la aplicación, asegurando su funcionalidad y estética.
   - Aplicar una plantilla de diseño para mantener la uniformidad visual en la aplicación.
2. **Navegación y accesibilidad**:
   - Crear un sistema de menús desplegables para agrupar opciones de navegación.
   - Asegurar que los menús principales estén accesibles en todas las páginas.
3. **Optimización visual y de contenido**:
   - Implementar una distribución accesible y ordenada de los elementos, uso adecuado de colores, imágenes y corrección de idioma.

---

## Instalación

 Clonar el repositorio.
   ```bash
   git clone https://github.com/tu-repositorio/hotel-boutique.git
