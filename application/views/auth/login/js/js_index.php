<script>
    const toogleEye = document.getElementById('eye-toggle');
    const textSecret = document.getElementById('text-secret');

    toogleEye.addEventListener('click', function(e) {
        const type = textSecret.getAttribute('type') === 'password' ? 'text' : 'password';
        textSecret.setAttribute('type', type);

        this.classList.toggle('fa-eye');
    });

    
</script>