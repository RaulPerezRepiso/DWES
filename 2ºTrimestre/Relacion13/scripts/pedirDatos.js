document.addEventListener("DOMContentLoaded", function () {

    const boton = document.getElementById("idBoton");
    const respuestaDiv = document.getElementById("idDiv");

    boton.addEventListener("click", function (e) {
        e.preventDefault();

        // Limpiar resultados previos
        respuestaDiv.innerHTML = "";

        // Obtener valores
        const min = document.getElementById("min").value;
        const max = document.getElementById("max").value;
        const cadena = document.getElementById("cadena").value;

        // Crear objeto XHR
        const xhr = new XMLHttpRequest();
        xhr.responseType = "json";

        // Definir qué hacer cuando cambie el estado
        xhr.onreadystatechange = function () {

            // Solo actuamos cuando la petición ha terminado
            if (xhr.readyState !== 4) return;

            // Si hubo error en la petición
            if (xhr.status !== 200) {
                respuestaDiv.innerHTML = "<p>Error en la petición AJAX</p>";
                return;
            }

            // Procesar respuesta JSON
            const datos = xhr.response;

            // Dibujar números
            let html = "<h3>Resultados</h3>";
            html += "<h4>Números</h4>";

            for (let i = 0; i < datos.numeros.length; i++) {
                html +=  datos.numeros[i] +" ";
            }

            // Dibujar palabras
            html += "<h4>Palabras</h4>";

            for (let i = 0; i < datos.palabras.length; i++) {
                html += "<p>" + datos.palabras[i] + "</p>";
            }

            respuestaDiv.innerHTML = html;
        };

        // Construir URL
        const url =
            "/practicas2/pedirDatos?min=" + encodeURIComponent(min) +
            "&max=" + encodeURIComponent(max) +
            "&cadena=" + encodeURIComponent(cadena);

        // Abrir y enviar petición
        xhr.open("GET", url, true);
        xhr.send();
    });
});
