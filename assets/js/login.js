document.addEventListener('alpine:init', () => {
    Alpine.data('loginForm', () => ({
        email: '',
        password: '',
        error: '',

        async submitForm() {
            try {
                const response = await fetch('/login-check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ email: this.email, password: this.password })
                });

                const data = await response.json();

                if (data.success) {
                window.location.href = data.redirect || '/game-home';
                } else {
                this.error = data.message || 'Identifiants incorrects';
                }
            } catch (e) {
                this.error = 'Erreur réseau';
            }
        }
    }));
    
});