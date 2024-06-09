function selectLaptop(id, categoria, button) {
    let selectedLaptops = localStorage.getItem('selectedLaptops');
    if (!selectedLaptops) {
        selectedLaptops = [];
    } else {
        selectedLaptops = JSON.parse(selectedLaptops);
    }

    // Crear un objeto portátil con id y categoría
    let laptop = { id: id, categoria: categoria };

    // Verificar si el portátil ya está seleccionado con la misma categoría
    if (selectedLaptops.length < 2 && !selectedLaptops.some(l => l.id === id && l.categoria === categoria)) {
        // Verificar si la categoría coincide con la categoría del primer elemento seleccionado (si existe)
        if (selectedLaptops.length === 0 || selectedLaptops[0].categoria === categoria || selectedLaptops.length === 1) {
            selectedLaptops.push(laptop);
            localStorage.setItem('selectedLaptops', JSON.stringify(selectedLaptops));
            button.classList.add('selected');
        }
    }

    if (selectedLaptops.length === 2) {
        window.location.href = 'pagina_comparadora.php?id1=' + selectedLaptops[0].id + '&categoria1=' + selectedLaptops[0].categoria + '&id2=' + selectedLaptops[1].id + '&categoria2=' + selectedLaptops[1].categoria;
        resetSelectedLaptops();
    }
}

function resetSelectedLaptops() {
    localStorage.removeItem('selectedLaptops');
    // Resetear los estilos de los botones
    const buttons = document.querySelectorAll('.botonComparar');
    buttons.forEach(button => button.classList.remove('selected'));
}

// Restaurar el estado de los botones seleccionados al cargar la página
window.onload = function() {
    let selectedLaptops = localStorage.getItem('selectedLaptops');
    if (selectedLaptops) {
        selectedLaptops = JSON.parse(selectedLaptops);
        selectedLaptops.forEach(laptop => {
            const button = document.querySelector(`.botonComparar[data-id="${laptop.id}"][data-categoria="${laptop.categoria}"]`);
            if (button) {
                button.classList.add('selected');
            }
        });
    }
};
