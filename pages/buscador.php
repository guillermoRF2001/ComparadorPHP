<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WikiGames</title>
  <link rel="icon" href="/proyectoAPI/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function cargarPagina(pageNumber) {
        var nombre = $('input[name="nombre"]').val();
        var consola = $('select[name="consola"]').val();
        var genre = $('input[name="genre"]').val(); 
        
        var formData = 'page=' + pageNumber;
        if (nombre != '') {
            formData += '&nombre=' + encodeURIComponent(nombre);
        }
        if (consola != '') {
            formData += '&consola=' + encodeURIComponent(consola);
        }
        if (genre != '') {
            formData += '&genre=' + encodeURIComponent(genre);
        }
        
        $.ajax({
            type: 'GET',
            url: '../components/buscadorAPI.php',
            data: formData,
            success: function(response) {
                $('.resultados').html(response);
            }
        });
    }
  </script>
</head>
<body>
<?php include_once('../components/header.php'); ?>
<div class="containerBuscador">
  <h1>Buscador de Videojuegos</h1>
  <form>
    <div>
      <label for="nombre">Nombre del juego:</label>
      <input type="text" id="nombre" name="nombre" >
    </div>
    <div>
      <label for="genre">Género:</label>
      <input type="text" id="genre" name="genre" >
    </div>
    <div>
      <label for="consola">Consola:</label>
      <select id="consola" name="consola">
        <option value=""></option>
        <option value="4">PC</option>
        <option value="5">macOS</option>
        <option value="6">Linux</option>
        <option value="1">Xbox One</option>
        <option value="10">Wii U</option>
        <option value="7">Switch</option>
        <option value="18">PlayStation 4</option>
        <!-- Agrega más opciones según sea necesario -->
      </select>
    </div>
    <button type="submit">Buscar</button>
  </form>
</div>
  <div class="resultados">
    <?php include_once('../components/buscadorAPI.php'); ?>
  </div> 
  <?php include_once('../components/footer.php'); ?>
</body>
</html>