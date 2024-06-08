document.addEventListener('DOMContentLoaded', (event) => {
    const stars = document.querySelectorAll('.starsComent .star');
    const puntuacionInput = document.getElementById('puntuacion');
    let previousValue = parseInt(puntuacionInput.value);

    stars.forEach(star => {
        star.addEventListener('click', (e) => {
            const value = parseInt(e.target.getAttribute('data-value'));

            if (previousValue === value) {
                puntuacionInput.value = 0;
                previousValue = 0;
            } else {
                puntuacionInput.value = value;
                previousValue = value;
            }

            stars.forEach((s, index) => {
                s.classList.toggle('empty', index >= puntuacionInput.value);
            });
        });
    });
});