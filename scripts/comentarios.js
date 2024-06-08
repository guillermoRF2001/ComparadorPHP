document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('comentario');
    const contador = document.getElementById('contador');
    const maxChars = 1000;

    textarea.addEventListener('input', function () {
        const currentLength = textarea.value.length;
        if (currentLength > maxChars) {
            textarea.value = textarea.value.substring(0, maxChars);
        }
        contador.textContent = `${textarea.value.length}/${maxChars}`;
    });
});