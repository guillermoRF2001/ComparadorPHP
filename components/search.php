<?php
include './BDconfig.php';
session_start();

if (isset($_GET['query'])) {
    $searchQuery = filter_var($_GET['query'], FILTER_SANITIZE_STRING);

    // Prepare the SQL statement
    $sql = "SELECT id, nombre, procesador, Ram, Espacio, grafica, precio, imagen 
            FROM productos 
            WHERE nombre LIKE ? 
               OR procesador LIKE ? 
               OR Ram LIKE ? 
               OR Espacio LIKE ? 
               OR grafica LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        $searchParam = '%' . $searchQuery . '%';
        mysqli_stmt_bind_param($stmt, "sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            // Check if any results were found
            if (mysqli_num_rows($result) > 0) {
                echo "<div>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div>";
                    echo "<h2>" . htmlspecialchars($row['nombre']) . "</h2>";
                    echo "<p>Procesador: " . htmlspecialchars($row['procesador']) . "</p>";
                    echo "<p>Ram: " . htmlspecialchars($row['Ram']) . "</p>";
                    echo "<p>Espacio: " . htmlspecialchars($row['Espacio']) . "</p>";
                    echo "<p>Gráfica: " . htmlspecialchars($row['grafica']) . "</p>";
                    echo "<p>Precio: $" . htmlspecialchars($row['precio']) . "</p>";
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" width="200" height="150"/>';
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "No results found for: " . htmlspecialchars($searchQuery);
            }
        } else {
            echo "Error executing search query.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing search query: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "No search query provided.";
}
?>