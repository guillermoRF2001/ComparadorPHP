// Obtener los datos de los juegos desde PHP
var gamesData = <?php echo $games_json; ?>;

// Agregar un evento de clic a cada elemento de juego
var gameElements = document.querySelectorAll('.game');
gameElements.forEach(function(gameElement, index) {
    gameElement.addEventListener('click', function() {
        var game = gamesData[index];
        var gameName = game.name;
        var gameImageSrc = game.background_image ? game.background_image : '../img/imgNoCarga.jpg';
        var gameGenres = game.genres.map(function(genre) {
            return genre.name;
        }).join(', ');
        var gameTags = game.tags.map(function(tag) {
            return tag.name;
        }).join(', ');
        var gamePlatforms = game.platforms.map(function(platform) {
            return platform.platform.name;
        }).join(', ');
        var releaseDate = game.released;
        var description = game.description || 'Descripción no disponible';

        // Mostrar más información en una ventana modal
        var modalContent = `
            <div class="modal-overlay" id="modalOverlay">
                <div class="modal">
                    <img src="${gameImageSrc}" alt="${gameName}">
                    <h2>${gameName}</h2>
                    <p><strong>Géneros:</strong> ${gameGenres}</p>
                    <p><strong>Plataformas:</strong> ${gamePlatforms}</p>
                    <p><strong>Fecha de lanzamiento:</strong> ${releaseDate}</p>
                    <p><strong>Descripción:</strong> ${description}</p>
                    <p><strong>Tags:</strong> ${gameTags}</p>
                </div>
            </div>
        `;

        // Agregar la ventana modal al cuerpo del documento
        document.body.insertAdjacentHTML('beforeend', modalContent);

        // Agregar un evento de clic al overlay para cerrar la modal
        var modalOverlay = document.getElementById('modalOverlay');
        modalOverlay.addEventListener('click', function(event) {
            if (event.target === modalOverlay) {
                modalOverlay.parentNode.removeChild(modalOverlay);
            }
        });
    });
});