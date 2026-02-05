<?php
require_once '../../header.php';

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['login_error'] = "Vous devez être connecté pour accéder à cette page.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// Vérifier si l'utilisateur est Modérateur
if(!isset($_SESSION['user_statut_nom']) || $_SESSION['user_statut_nom'] !== 'Modérateur') {
    header('Location: /index.php');
    exit;
}
?>

<!-- DASHBOARD ADMIN -->
<div class="container my-5">
    
    <!-- Titre principal -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center display-5 fw-bold">Liens permettant d'administrer le Blog d'Articles</h1>
            <hr class="my-4">
        </div>
    </div>
    
    <!-- Message de bienvenue -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Bienvenue sur le dashboard !</strong> Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($_SESSION['user_pseudo']); ?></strong>
            </div>
        </div>
    </div>
    
    <!-- Tableau des actions -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 15%;">Objets</th>
                            <th scope="col" style="width: 35%;">Actions</th>
                            <th scope="col" style="width: 50%;">Commentaires</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Statuts -->
                        <tr>
                            <td><strong>Statuts</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/statuts/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/statuts/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/statuts/edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/statuts/delete.php" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td>Exemple fourni, s'y référer pour les autres CRUD</td>
                        </tr>
                        
                        <!-- Membres -->
                        <tr>
                            <td><strong>Membres</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/members/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/members/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/members/edit.php" class="btn btn-sm btn-warning" disabled>
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/members/delete.php" class="btn btn-sm btn-danger" disabled>
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td>Pour tous les membres : Inscription, connexion, sécurité et captcha</td>
                        </tr>
                        
                        <!-- Articles -->
                        <tr>
                            <td><strong>Articles</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/articles/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/articles/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/articles/edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/articles/delete.php" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td>En même temps que l'article : image à intégrer, gestion des mots-clés associés</td>
                        </tr>
                        
                        <!-- Thématiques -->
                        <tr>
                            <td><strong>Thématiques</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/thematiques/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/thematiques/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/thematiques/edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/thematiques/delete.php" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        
                        <!-- Commentaires -->
                        <tr>
                            <td><strong>Commentaires</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/comments/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/comments/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/comments/edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/comments/delete.php" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td>Gestion côté front et côté back, modération. Utilisation de mise en forme (emojies...)</td>
                        </tr>
                        
                        <!-- Likes -->
                        <tr>
                            <td><strong>Likes</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/likes/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/likes/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/likes/edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/likes/delete.php" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td>Utilisation de JS</td>
                        </tr>
                        
                        <!-- Mot-clés -->
                        <tr>
                            <td><strong>Mot-clés</strong></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/views/backend/keywords/list.php" class="btn btn-sm btn-primary">
                                        <i class="fas fa-list me-1"></i>List
                                    </a>
                                    <a href="/views/backend/keywords/create.php" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Create
                                    </a>
                                    <a href="/views/backend/keywords/edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="/views/backend/keywords/delete.php" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

<?php require_once '../../footer.php'; ?>