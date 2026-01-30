<?php
// Include the main header file containing database and utility functions
include '../../../header.php';
?>

<!-- Formulaire de connexion (Login) -->
<!-- Page permettant à un utilisateur existant de se connecter à son compte -->
<div class="container mt-5">
    <div class="row">
        <!-- Centrer le formulaire et limiter la largeur pour meilleure lisibilité -->
        <div class="col-md-5 offset-md-3.5">
            <!-- Titre principal -->
            <h1 class="mb-4">Connexion</h1>

            <!-- Affichage des messages d'erreur/succès s'il y en a -->
            <?php if(isset($_GET['error'])): ?>
                <!-- Alerte d'erreur affichée en haut du formulaire -->
                <div class="alert alert-danger" role="alert">
                    <?php 
                    // Afficher un message d'erreur approprié selon le code d'erreur reçu
                    switch($_GET['error']){
                        case 'invalid_credentials':
                            echo "Pseudo ou mot de passe incorrect.";
                            break;
                        case 'user_not_found':
                            echo "Cet utilisateur n'existe pas.";
                            break;
                        case 'database_error':
                            echo "Une erreur est survenue. Veuillez réessayer.";
                            break;
                        default:
                            echo "Une erreur est survenue lors de la connexion.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Message de succès si l'inscription a réussi -->
            <?php if(isset($_GET['success']) && $_GET['success'] === 'signup_ok'): ?>
                <div class="alert alert-success" role="alert">
                    Inscription réussie ! Veuillez vous connecter avec vos identifiants.
                </div>
            <?php endif; ?>

            <!-- Formulaire de connexion -->
            <!-- action : pointe vers l'API backend qui traitera l'authentification -->
            <!-- method="post" : envoie les données de manière sécurisée (non visibles dans l'URL) -->
            <form action="<?php echo ROOT_URL . '/api/security/login.php' ?>" method="post" id="loginForm">
                
                <!-- Champ Pseudo de connexion -->
                <!-- L'utilisateur entre son pseudo (6+ caractères) -->
                <div class="form-group mb-4">
                    <label for="pseudoMemb" class="form-label">Pseudo</label>
                    <input 
                        id="pseudoMemb" 
                        name="pseudoMemb" 
                        class="form-control" 
                        type="text" 
                        placeholder=""
                        required 
                        minlength="6"
                        autofocus="autofocus" />
                    <small class="form-text text-muted">(Au - 6 caractères)</small>
                </div>

                <!-- Champ Mot de passe -->
                <!-- Le mot de passe est masqué avec type="password" -->
                <div class="form-group mb-4">
                    <label for="passwordMemb" class="form-label">Password</label>
                    <input 
                        id="passwordMemb" 
                        name="passwordMemb" 
                        class="form-control" 
                        type="password" 
                        placeholder=""
                        required 
                        minlength="8"
                        maxlength="15" />
                    <small class="form-text text-muted">(Entre 8 et 15 car., au - une majuscule, une minuscule, un chiffre, car. spéciaux acceptés)</small>
                    
                    <!-- Checkbox pour afficher/masquer le mot de passe -->
                    <div class="form-check mt-2">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="showPassword"
                            onclick="togglePasswordVisibility('passwordMemb', 'showPassword')" />
                        <label class="form-check-label" for="showPassword">
                            Afficher Mot de passe
                        </label>
                    </div>
                </div>

                <!-- reCAPTCHA -->
                <!-- Intégration du reCAPTCHA v3 de Google pour prévention des bots -->
                <div class="form-group mb-4">
                    <div class="g-recaptcha" data-sitekey="VOTRE_SITE_KEY_RECAPTCHA"></div>
                    <small class="form-text text-muted">Je ne suis pas un robot</small>
                </div>

                <!-- Bouton de connexion -->
                <div class="form-group d-grid gap-2 mb-4">
                    <!-- Bouton de soumission du formulaire (couleur primaire/teal) -->
                    <button type="submit" class="btn btn-outline-success" style="border-color: #17a2b8; color: #17a2b8; padding: 10px 30px; font-size: 16px;">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pied de page avec lien de création de compte -->
<footer class="mt-5 text-center pb-4">
    <p class="text-muted">Blog'Art 25</p>
    <a href="<?php echo ROOT_URL . '/views/backend/security/signup.php' ?>" class="btn btn-outline-primary" style="border-color: #007bff; color: #007bff;">
        Créer un compte
    </a>
</footer>

<!-- Script pour afficher/masquer le mot de passe -->
<script>
// Fonction pour basculer la visibilité du mot de passe
function togglePasswordVisibility(fieldId, checkboxId) {
    const passwordField = document.getElementById(fieldId);
    const checkbox = document.getElementById(checkboxId);
    
    if (checkbox.checked) {
        // Afficher le mot de passe
        passwordField.type = 'text';
    } else {
        // Masquer le mot de passe
        passwordField.type = 'password';
    }
}
</script>

<!-- Script pour charger reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php
// Note: N'inclure le footer que si tu veux, sinon commenter la ligne suivante
// include '../../../footer.php';
?>
