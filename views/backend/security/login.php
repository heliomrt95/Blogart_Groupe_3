<?php 
require_once '../../../header.php';

$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
$signup_success = isset($_SESSION['signup_success']) ? $_SESSION['signup_success'] : '';

unset($_SESSION['login_error']);
unset($_SESSION['signup_success']);
?>

<div class="page-connexion">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                
                <h1 class="page-connexion-title">Connexion</h1>
                <hr class="page-connexion-divider">
                
                <?php if ($login_error): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo htmlspecialchars($login_error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($signup_success): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo htmlspecialchars($signup_success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="login-card">
                    <h2 class="login-greeting">Bonjour !</h2>
                    <p class="login-subtitle">Connectez-vous pour accéder à votre compte</p>
                    
                    <form method="POST" action="/api/security/login.php">
                        
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" class="form-control" id="pseudo" name="pseudo" required placeholder="Votre pseudo">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Votre mot de passe">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)" style="border: none; background: transparent;">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-connexion w-100 mt-4">
                            Se connecter
                        </button>
                        
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">
                            Pas encore de compte ? 
                            <a href="/views/backend/security/signup.php" class="link-inscription">S'inscrire</a>
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<?php require_once '../../../footer.php'; ?>