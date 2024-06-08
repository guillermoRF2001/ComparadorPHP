document.getElementById('categoria').addEventListener('change', function() {
    var categoria = this.value;
    var pantallaContainer = document.getElementById('pantallaContainer');
    if (categoria === 'portatil') {
        pantallaContainer.style.display = 'flex';
    } else {
        pantallaContainer.style.display = 'none';
    }
});
