document.querySelector('.register-form').addEventListener('submit', function (event) {
    const contactNumber = document.getElementById('contact-number').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    // Validate contact number
    if (!/^+94[0-9]{9}$/.test(contactNumber)) {
        alert("Invalid contact number. It should follow the format '+94XXXXXXXX'.");
        event.preventDefault();
        return;
    }

    // Validate email
    if (!/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
        alert("Invalid email format. Please use a valid '@gmail.com' email.");
        event.preventDefault();
        return;
    }

    // Validate password match
    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        event.preventDefault();
        return;
    }
});