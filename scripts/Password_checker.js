document.getElementById("signupForm").addEventListener("submit", function(event) {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("password2").value;
    var passwordLength = password.length;
    var hasNumber = /\d/.test(password);

    if (passwordLength < 6 || passwordLength > 14) {
        callAlert("Password must be between 6 and 14 characters");
        event.preventDefault(); 
    } else if (!hasNumber) {
        callAlert("Password must contain at least one number");
        event.preventDefault(); 
    } else if (password !== confirmPassword) {
        callAlert("Passwords do not match");
        event.preventDefault(); 
    }
});


function callAlert(mensaje){
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: mensaje,
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
        
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
            timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    });
}
