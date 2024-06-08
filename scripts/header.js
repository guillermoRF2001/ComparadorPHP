document.addEventListener('DOMContentLoaded', function() {
    var mostrarCajaBtn = document.getElementById('mostrarCaja');
    var caja = document.getElementById('caja');
    var fondo = document.getElementById('fondo');
    var close = document.getElementById('closeIcon');
    var fila1 = document.getElementById('fila1');
    var fila2 = document.getElementById('fila2');
    var info1 = document.getElementById('info1');
    var info2 = document.getElementById('info2');


    const profileContainer = document.getElementById('cajaUserDrop');
    const dropdownMenu = document.getElementById('dropHeader');


    if (mostrarCajaBtn) {
        mostrarCajaBtn.addEventListener('click', function() {
            if (caja.style.display === 'none' || caja.style.display === '') {
                caja.style.display = 'block';
                fondo.style.display = 'block';
            } else {
                caja.style.display = 'none';
                fondo.style.display = 'none';
            }
        });


        //fondo
        fondo.addEventListener('click', function() {
            if (caja.style.display === 'none' || caja.style.display === '') {
                caja.style.display = 'block';
                fondo.style.display = 'block';
            } else {
                caja.style.display = 'none';
                fondo.style.display = 'none';
            }
        });

        close.addEventListener('click', function() {
            if (caja.style.display === 'none' || caja.style.display === '') {
                caja.style.display = 'block';
                fondo.style.display = 'block';
            } else {
                caja.style.display = 'none';
                fondo.style.display = 'none';
            }
        });

        fila1.addEventListener('click', function() {
            if (info1.style.display === 'block') {
                info1.style.display = 'none';
            } else {
                info1.style.display = 'block';
                info2.style.display = 'none';
            }
        });

        fila2.addEventListener('click', function() {
            if (info2.style.display === 'block') {
                info2.style.display = 'none';
            } else {
                info2.style.display = 'block';
                info1.style.display = 'none';
            }
        });

    }


    profileContainer.addEventListener('mouseleave', () => {
        dropdownMenu.style.display = 'none';
    });

    profileContainer.addEventListener('mouseover', () => {
        dropdownMenu.style.display = 'block';
    });

    dropdownMenu.addEventListener('mouseover', () => {
        dropdownMenu.style.display = 'block';
    });

    dropdownMenu.addEventListener('mouseleave', () => {
        dropdownMenu.style.display = 'none';
    });
});