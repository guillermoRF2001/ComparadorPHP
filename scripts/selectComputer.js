function selectLaptop(id, button) {
    let selectedLaptops = localStorage.getItem('selectedLaptops');
    if (!selectedLaptops) {
        selectedLaptops = [];
    } else {
        selectedLaptops = JSON.parse(selectedLaptops);
    }

    if (selectedLaptops.length < 2 && !selectedLaptops.includes(id)) {
        selectedLaptops.push(id);
        localStorage.setItem('selectedLaptops', JSON.stringify(selectedLaptops));
        button.classList.add('selected');
    }

    if (selectedLaptops.length === 2) {
        window.location.href = 'pagina_comparadora.php?id1=' + selectedLaptops[0] + '&id2=' + selectedLaptops[1];
    }
}

function resetSelectedLaptops() {
    localStorage.removeItem('selectedLaptops');
    // Reset the button styles
    const buttons = document.querySelectorAll('.botonComparar');
    buttons.forEach(button => button.classList.remove('selected'));
}

// Reset selected laptops when the page loads
window.onload = resetSelectedLaptops;