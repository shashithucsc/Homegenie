document.querySelector('.register-form').addEventListener('submit', function (event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    // Validate password match
    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        event.preventDefault();
        return;
    }
});