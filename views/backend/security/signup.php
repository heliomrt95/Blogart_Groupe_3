<?php 
require_once '../../../header.php';

// Afficher message d'erreur
if (isset($_SESSION['signup_error'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $_SESSION['signup_error'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>';
    unset($_SESSION['signup_error']);
}
?>

<!-- PAGE INSCRIPTION -->
<section class="page-inscription">
    <div class="container">
        <!-- Titre de la page -->
        <h1 class="page-inscription-title">Inscription</h1>
        <hr class="page-inscription-divider">
        
        <!-- Formulaire centré avec Bootstrap -->
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="signup-card">
                    <h2 class="signup-greeting">Bonjour</h2>
                    <p class="signup-subtitle">Créez votre compte pour continuer</p>
                    
                    <form action="/api/security/signup.php" method="POST" id="signupForm">
                        <!-- Pseudonyme -->
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">
                                Pseudonyme <span class="text-muted">(définitif)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="pseudo" 
                                       name="pseudo" 
                                       placeholder="Votre pseudonyme" 
                                       minlength="6"
                                       required>
                            </div>
                            <small class="form-text text-muted">Min. 6 caractères.</small>
                        </div>
                        
                        <!-- Prénom -->
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="prenom" 
                                   name="prenom" 
                                   placeholder="Votre prénom" 
                                   required>
                        </div>
                        
                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nom" 
                                   name="nom" 
                                   placeholder="Votre nom" 
                                   required>
                        </div>
                        
                        <!-- eMail -->
                        <div class="mb-3">
                            <label for="email" class="form-label">eMail</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       placeholder="votre@email.com" 
                                       required>
                            </div>
                        </div>
                        
                        <!-- Confirmez eMail -->
                        <div class="mb-3">
                            <label for="email_confirm" class="form-label">Confirmez eMail</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-check-fill"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email_confirm" 
                                       name="email_confirm" 
                                       placeholder="votre@email.com" 
                                       required>
                            </div>
                        </div>
                        
                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Votre mot de passe"
                                       minlength="8"
                                       maxlength="15"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        id="togglePassword"
                                        style="border: none; background: transparent;">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Entre 8 et 15 caractères.</small>
                        </div>
                        
                        <!-- Confirmez mot de passe -->
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmez mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       placeholder="Votre mot de passe"
                                       minlength="8"
                                       maxlength="15"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        id="togglePasswordConfirm"
                                        style="border: none; background: transparent;">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- RGPD -->
                        <div class="mb-3">
                            <label class="form-label d-block">J'accepte que mes données soient conservées</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="rgpd" 
                                       id="rgpdOui" 
                                       value="1" 
                                       required>
                                <label class="form-check-label" for="rgpdOui">Oui</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="rgpd" 
                                       id="rgpdNon" 
                                       value="0">
                                <label class="form-check-label" for="rgpdNon">Non</label>
                            </div>
                        </div>
                        
                        <!-- Badge reCAPTCHA v3 (invisible) -->
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        
                        <!-- Bouton S'inscrire -->
                        <button type="submit" class="btn btn-inscription w-100 mb-3" id="submitBtn">
                            S'inscrire
                        </button>
                        
                        <!-- Lien Connexion -->
                        <p class="text-center mb-0">
                            <small class="text-muted">Vous avez déjà un compte ? 
                                <a href="/views/backend/security/login.php" class="link-connexion">Se connecter</a>
                            </small>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- reCAPTCHA v3 Script -->
<script src="https://www.google.com/recaptcha/api.js?render=6LcW8l0sAAAAANgcNyfe-zFagqLEFB1a0fG9FIC8"></script>

<!-- Scripts -->
<script>
// reCAPTCHA v3
document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Inscription en cours...';
    
    grecaptcha.ready(function() {
        grecaptcha.execute('6LcW8l0sAAAAANgcNyfe-zFagqLEFB1a0fG9FIC8', {action: 'signup'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
            document.getElementById('signupForm').submit();
        }).catch(function(error) {
            console.error('Erreur reCAPTCHA:', error);
            submitBtn.disabled = false;
            submitBtn.textContent = 'S\'inscrire';
            alert('Erreur reCAPTCHA. Veuillez recharger la page.');
        });
    });
});

// Toggle password
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
});

// Toggle password confirm
document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
    const passwordInput = document.getElementById('password_confirm');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
});
</script>

<?php require_once '../../../footer.php'; ?>