<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WikiGames</title>
    <link rel="icon" href="/proyectoAPI/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
 
</head>
<body>
<?php include_once('../components/header.php'); ?>
    <?php include '../components/sliderNew.php'; ?>
    <h1>NEW RELEASES</h1>
    <div class="resultados">
        <?php include '../components/new.php'; ?>
    </div>
    <?php include '../components/gameDetailNew.php'; ?>
   <div></div>
   <?php include '../components/footer.php'; ?>
</body>
</html>