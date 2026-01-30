<?php
// Include the main header file containing database and utility functions
include '../../../header.php';
?>

<!-- Formulaire d'inscription (Signup) -->
<!-- Page permettant à un nouvel utilisateur de créer un compte -->
<div class="container mt-5">
    <div class="row">
        <!-- Centrer le formulaire et limiter la largeur pour meilleure lisibilité -->
        <div class="col-md-6 offset-md-3">
            <!-- Titre principal -->
            <h1 class="mb-4">Inscription</h1>

            <!-- Formulaire d'inscription -->
            <!-- action : pointe vers l'API backend qui traitera l'enregistrement -->
            <!-- method="post" : envoie les données de manière sécurisée (non visibles dans l'URL) -->
            <form action="<?php echo ROOT_URL . '/api/security/signup.php' ?>" method="post" id="signupForm">
                
                <!-- Champ Pseudo de l'utilisateur -->
                <!-- Le pseudo doit être unique dans la base de données (6+ caractères) -->
                <div class="form-group mb-4">
                    <label for="pseudoMemb" class="form-label">Pseudo (non modifiable)</label>
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

                <!-- Champ Prénom de l'utilisateur -->
                <div class="form-group mb-4">
                    <label for="prenomMemb" class="form-label">Prénom</label>
                    <input 
                        id="prenomMemb" 
                        name="prenomMemb" 
                        class="form-control" 
                        type="text" 
                        placeholder="" />
                </div>

                <!-- Champ Nom de l'utilisateur -->
                <div class="form-group mb-4">
                    <label for="nomMemb" class="form-label">Nom</label>
                    <input 
                        id="nomMemb" 
                        name="nomMemb" 
                        class="form-control" 
                        type="text" 
                        placeholder="" />
                </div>

                <!-- Champ Email de l'utilisateur -->
                <!-- Format email validé par le navigateur (6+ caractères) -->
                <div class="form-group mb-4">
                    <label for="eMailMemb" class="form-label">eMail</label>
                    <input 
                        id="eMailMemb" 
                        name="eMailMemb" 
                        class="form-control" 
                        type="email" 
                        placeholder=""
                        required 
                        minlength="6" />
                    <small class="form-text text-muted">(Au - 6 caractères)</small>
                </div>

                <!-- Champ Confirmation Email -->
                <!-- Validation côté serveur pour vérifier que les emails correspondent -->
                <div class="form-group mb-4">
                    <label for="eMailMemb_confirm" class="form-label">Confirmez eMail</label>
                    <input 
                        id="eMailMemb_confirm" 
                        name="eMailMemb_confirm" 
                        class="form-control" 
                        type="email" 
                        placeholder=""
                        required 
                        minlength="6" />
                    <small class="form-text text-muted">(Au - 6 caractères)</small>
                </div>

                <!-- Champ Mot de passe -->
                <!-- Validation stricte : 8-15 caractères, majuscule, minuscule, chiffre, caractère spécial -->
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
                        maxlength="15"
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-_@.#$%^&*])[a-zA-Z0-9-_@.#$%^&*]{8,15}$"
                        title="Entre 8 et 15 caractères avec une majuscule, une minuscule, un chiffre et un caractère spécial (-_@.#$%^&*)" />
                    <small class="form-text text-muted">(Entre 8 et 15 car. : une majuscule, une minuscule, un chiffre, car. spéciaux acceptés au - un)</small>
                    
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

                <!-- Champ Confirmation Mot de passe -->
                <div class="form-group mb-4">
                    <label for="passwordMemb_confirm" class="form-label">Confirmez Password</label>
                    <input 
                        id="passwordMemb_confirm" 
                        name="passwordMemb_confirm" 
                        class="form-control" 
                        type="password" 
                        placeholder=""
                        required 
                        minlength="8"
                        maxlength="15"
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-_@.#$%^&*])[a-zA-Z0-9-_@.#$%^&*]{8,15}$"
                        title="Entre 8 et 15 caractères avec une majuscule, une minuscule, un chiffre et un caractère spécial (-_@.#$%^&*)" />
                    <small class="form-text text-muted">(Entre 8 et 15 car. : une majuscule, une minuscule, un chiffre, car. spéciaux acceptés, au - un)</small>
                    
                    <!-- Checkbox pour afficher/masquer le mot de passe -->
                    <div class="form-check mt-2">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="showPasswordConfirm"
                            onclick="togglePasswordVisibility('passwordMemb_confirm', 'showPasswordConfirm')" />
                        <label class="form-check-label" for="showPasswordConfirm">
                            Afficher Mot de passe
                        </label>
                    </div>
                </div>

                <!-- Acceptation de la conservation des données (RGPD) -->
                <!-- Radio buttons : Oui / Non (Non sélectionné par défaut) -->
                <div class="form-group mb-4">
                    <label class="form-label">J'accepte que mes données soient conservées</label>
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="acceptData" 
                            id="acceptDataYes" 
                            value="1"
                            required />
                        <label class="form-check-label" for="acceptDataYes">
                            Oui
                        </label>
                    </div>
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="acceptData" 
                            id="acceptDataNo" 
                            value="0"
                            checked
                            required />
                        <label class="form-check-label" for="acceptDataNo">
                            Non
                        </label>
                    </div>
                </div>

                <!-- reCAPTCHA -->
                <!-- Intégration du reCAPTCHA v3 de Google pour prévention des bots -->
                <div class="form-group mb-4">
                    <div class="g-recaptcha" data-sitekey="VOTRE_SITE_KEY_RECAPTCHA"></div>
                    <small class="form-text text-muted">Je ne suis pas un robot</small>
                </div>

                <!-- Boutons d'action -->
                <!-- Disposition horizontale des boutons -->
                <div class="form-group d-flex gap-2 justify-content-between">
                    <!-- Bouton de création (couleur primaire/teal) -->
                    <button type="submit" class="btn btn-outline-success" style="border-color: #17a2b8; color: #17a2b8;">
                        Création
                    </button>
                    
                    <!-- Lien vers page de connexion si compte existant -->
                    <a href="<?php echo ROOT_URL . '/views/backend/security/login.php' ?>" class="btn btn-outline-primary">
                        Déjà un compte ?
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script pour afficher/masquer les mots de passe -->
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

// Validation côté client pour les mots de passe
document.getElementById('signupForm').addEventListener('submit', function(e) {
    const password = document.getElementById('passwordMemb').value;
    const passwordConfirm = document.getElementById('passwordMemb_confirm').value;
    const email = document.getElementById('eMailMemb').value;
    const emailConfirm = document.getElementById('eMailMemb_confirm').value;
    const acceptData = document.querySelector('input[name="acceptData"]:checked').value;
    
    // Vérifier que les mots de passe correspondent
    if (password !== passwordConfirm) {
        e.preventDefault();
        alert('Les mots de passe ne correspondent pas.');
        return false;
    }
    
    // Vérifier que les emails correspondent
    if (email !== emailConfirm) {
        e.preventDefault();
        alert('Les adresses email ne correspondent pas.');
        return false;
    }
    
    // Vérifier que l'utilisateur accepte la conservation des données
    if (acceptData === '0') {
        e.preventDefault();
        alert('Vous devez accepter que vos données soient conservées pour créer un compte.');
        return false;
    }
    
    return true;
});
</script>

<!-- Script pour charger reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php
include '../../../footer.php';
?>