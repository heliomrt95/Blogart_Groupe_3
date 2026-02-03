<?php 
require_once '../../../header.php';

// Afficher message de succès inscription (vert)
if (isset($_SESSION['signup_success'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . $_SESSION['signup_success'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>';
    unset($_SESSION['signup_success']);
}

// Afficher message d'erreur login (rouge)
if (isset($_SESSION['login_error'])) {
    echo '<div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $_SESSION['login_error'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>';
    unset($_SESSION['login_error']);
}
?>

<!-- PAGE CONNEXION -->
<section class="page-connexion">
    <div class="container">
        <!-- Titre de la page -->
        <h1 class="page-connexion-title">Connexion</h1>
        <hr class="page-connexion-divider">
        
        <!-- Formulaire centré avec Bootstrap -->
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="login-card">
                    <h2 class="login-greeting">Bonjour</h2>
                    <p class="login-subtitle">Connectez-vous pour continuer</p>
                    
                    <form action="/api/security/login.php" method="POST">
                        <!-- Pseudonyme -->
                        <div class="mb-4">
                            <label for="pseudo" class="form-label">Pseudonyme</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="pseudo" 
                                       name="pseudo" 
                                       placeholder="Votre pseudonyme" 
                                       required
                                       autocomplete="username">
                            </div>
                        </div>
                        
                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Votre mot de passe" 
                                       required
                                       autocomplete="current-password">
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Bouton Se connecter -->
                        <button type="submit" class="btn btn-connexion w-100 mb-3">
                            Se connecter
                        </button>
                        
                        <!-- Lien Inscription -->
                        <p class="text-center mb-0">
                            <small class="text-muted">Vous n'avez pas de compte ? 
                                <a href="/views/backend/security/signup.php" class="link-inscription">S'inscrire</a>
                            </small>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script pour toggle password -->
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
});
</script>

<?php require_once '../../../footer.php'; ?>