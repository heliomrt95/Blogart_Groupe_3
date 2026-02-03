<?php
// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';

// Déterminer la page actuelle
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LEKÉ - Blog de Bordeaux</title>
    
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- GOOGLE FONTS - POPPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- TON CSS MINIMAL -->
    <link rel="stylesheet" href="/src/css/style.css" />
    
    <link rel="shortcut icon" href="/src/images/logo.png" />
</head>
<body>

<!-- NAVBAR BOOTSTRAP - BLEU FONCÉ #2F509E -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2F509E;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/index.php">
            <img src="/src/images/logo.png" alt="LEKÉ" height="35" class="me-2">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'index') ? 'fw-bold' : ''; ?>" 
                       href="/index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'articles') ? 'fw-bold' : ''; ?>" 
                       href="/views/frontend/articles.php">Articles</a>
                </li>
                
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <!-- Utilisateur CONNECTÉ -->
                    
                    <?php if(isset($_SESSION['user_statut_nom']) && $_SESSION['user_statut_nom'] === 'Modérateur'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/views/backend/dashboard.php">Admin</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/api/security/disconnect.php">
                            Déconnexion (<?php echo htmlspecialchars($_SESSION['user_pseudo']); ?>)
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Utilisateur NON CONNECTÉ -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'login') ? 'fw-bold' : ''; ?>" 
                           href="/views/backend/security/login.php">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>