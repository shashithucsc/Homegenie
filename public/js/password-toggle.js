document.addEventListener('DOMContentLoaded', function() {
    const passwordContainers = document.querySelectorAll('.password-container');
    
    passwordContainers.forEach(container => {
        const passwordInput = container.querySelector('input[type="password"]');
        const toggleIcon = container.querySelector('.show-hide');
        
        if (passwordInput && toggleIcon) {
            toggleIcon.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                this.classList.toggle('bx-hide');
                this.classList.toggle('bx-show');
            });
        }
    });
}); 