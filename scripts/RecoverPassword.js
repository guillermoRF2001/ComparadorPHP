document.getElementById("CheckEmail").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenimos el comportamiento predeterminado del formulario

    var email = document.getElementById("username").value;

    // Realizar una solicitud al servidor para enviar el correo electrónico
    fetch("/ComparadorPHP/components/send_recovery_email.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "email=" + email,
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Si la respuesta es exitosa, mostrar un mensaje de éxito al usuario
            Swal.fire({
                icon: "success",
                title: "Email sended",
                text: "You'll receive an email with a secure link to reset your password. If you don't see the email in your inbox, please check your spam or junk folder.",
                timer: 6000,
                timerProgressBar: true,
                didOpen: () => {
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            });
        } else {
            // Si hay un error en la respuesta, mostrar un mensaje de error al usuario
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong! Please try again later.",
                showConfirmButton: false,
                timer: 3000,
            });
        }
    })
    .catch(function(error) {
        console.error("Error:", error);
        // Si hay un error en la solicitud, mostrar un mensaje de error al usuario
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong! Please try again later.",
            showConfirmButton: false,
            timer: 3000,
        });
    });
});