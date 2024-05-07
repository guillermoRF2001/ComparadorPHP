<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WikiGames</title>
    <link rel="icon" href="/proyectoAPI/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/style.css">
 
</head>
<body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/sliderPopular.php'; ?>
    <h1>TOP SELLERS</h1>
    <div class="resultados">
        <?php include 'components/popular.php'; ?>
    </div>
    <?php include 'components/gameDetailPopular.php'; ?>
    <?php include './components/footer.php'; ?>
</body>
</html>