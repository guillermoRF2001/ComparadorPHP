function confirmDelete(id, categoria) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará el ordenador permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si se confirma la eliminación, redirigir al script de eliminación
            window.location.href = "/ComparadorPHP/components/delete.php?id=" + id + "&categoria=" + categoria;
        }
    });
}