<script>
document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const togglePasswordIcon = document.querySelector('#togglePasswordIcon');

    togglePassword.addEventListener('click', function () {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // toggle the eye / eye-off icon
        if (type === 'password') {
            togglePasswordIcon.classList.remove('ti-eye-off');
            togglePasswordIcon.classList.add('ti-eye');
        } else {
            togglePasswordIcon.classList.remove('ti-eye');
            togglePasswordIcon.classList.add('ti-eye-off');
        }
    });
});
</script>
