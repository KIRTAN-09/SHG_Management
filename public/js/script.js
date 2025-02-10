document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const body = document.body;
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');

    registerBtn.addEventListener('click', () => {
        container.classList.add('register-mode');
        container.classList.remove('animate-background');
        body.classList.remove('animate-background');
        void container.offsetWidth; // Trigger reflow to restart animation
        container.classList.add('animate-background');
        body.classList.add('register-mode-active');
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove('register-mode');
        body.classList.remove('register-mode-active');
        container.classList.remove('animate-background');
        void container.offsetWidth; // Trigger reflow to restart animation
        container.classList.add('animate-background');
    });

}); 