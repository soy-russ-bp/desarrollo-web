function fetchRoomDetails(roomId) {
    console.log(`Fetching details for room ID: ${roomId}`);
    const popup = document.getElementById(`popup-${roomId}`);
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `Habitaciones/ObtenerHabitacion.php?id=${roomId}`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log(`Response: ${xhr.responseText}`);
                popup.innerHTML = xhr.responseText;
                popup.classList.add("show"); // Muestra el popup
            } else {
                console.error(`Error: ${xhr.status}`);
                popup.innerHTML = "Error al cargar los detalles.";
            }
        }
    };
    xhr.send();
}

function hideRoomDetails(roomId) {
    console.log(`Hiding details for room ID: ${roomId}`);
    const popup = document.getElementById(`popup-${roomId}`);
    popup.classList.remove("show"); // Oculta el popup
    popup.innerHTML = ""; // Limpia el contenido del popup
}
