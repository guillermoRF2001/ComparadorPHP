<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Imagen Actualizada</title>
</head>
<body>
    <?php
    // Include the database configuration file
    require_once './BDconfig.php';

    // Prepare the query to get the first image from the table
    $sql = "SELECT imagen FROM portatil LIMIT 1";
    $result = $conn->query($sql);

    // Check if at least one image was found
    if ($result->num_rows > 0) {
        // Fetch the image data
        $row = $result->fetch_assoc();
        $imagen = $row['imagen'];

        // Set the content type and output the image
        echo '<img src="data:image/jpeg;base64,'.base64_encode($imagen).'" alt="Imagen Actualizada">';
    } else {
        echo "Imagen no encontrada.";
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>