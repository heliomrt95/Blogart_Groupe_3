<?php
require_once '../../../header.php';

// Vérifier que c'est un modérateur
if(!isset($_SESSION['user_statut_nom']) || $_SESSION['user_statut_nom'] !== 'Modérateur') {
    header('Location: /index.php');
    exit;
}

// Charger tous les articles avec leur thématique
$query = "SELECT a.*, t.libThem 
          FROM ARTICLE a 
          LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
          ORDER BY a.dtCreaArt DESC";

global $DB;
if(!$DB){
    sql_connect();
}
$articles = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    
    <!-- Messages de succès/erreur -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted') { ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>
            Article supprimé avec succès !
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>
    
    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Erreur : <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>
    
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Gestion des articles</h1>
        <a href="create.php" class="btn btn-success">
            <i class="bi bi-plus-lg me-2"></i>Créer un article
        </a>
    </div>
    
    <!-- Liste des articles -->
    <?php if (count($articles) > 0) { ?>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">Image</th>
                                <th>Titre</th>
                                <th>Chapeau</th>
                                <th>Thématique</th>
                                <th>Date</th>
                                <th style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($articles as $article) { ?>
                                <tr>
                                    <!-- Image -->
                                    <td>
                                        <?php if (!empty($article['urlPhotArt'])) { ?>
                                            <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                                                 alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <?php } else { ?>
                                            <div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    
                                    <!-- Titre -->
                                    <td>
                                        <div class="fw-semibold"><?php echo htmlspecialchars(substr($article['libTitrArt'], 0, 50)); ?></div>
                                    </td>
                                    
                                    <!-- Chapeau -->
                                    <td>
                                        <small class="text-muted">
                                            <?php echo htmlspecialchars(substr($article['libChapoArt'], 0, 60)) . '...'; ?>
                                        </small>
                                    </td>
                                    
                                    <!-- Thématique -->
                                    <td>
                                        <?php if (!empty($article['libThem'])) { ?>
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($article['libThem']); ?></span>
                                        <?php } else { ?>
                                            <span class="text-muted">N/A</span>
                                        <?php } ?>
                                    </td>
                                    
                                    <!-- Date -->
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('d/m/Y', strtotime($article['dtCreaArt'])); ?>
                                        </small>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Voir -->
                                            <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                                               class="btn btn-sm btn-outline-primary"
                                               target="_blank"
                                               title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            <!-- Modifier -->
                                            <a href="edit.php?numArt=<?php echo $article['numArt']; ?>" 
                                               class="btn btn-sm btn-outline-warning"
                                               title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            <!-- Supprimer -->
                                            <a href="/api/articles/delete.php?id=<?php echo $article['numArt']; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Voulez-vous vraiment supprimer cet article ?\n\nTous les éléments associés seront également supprimés :\n✗ Commentaires\n✗ Likes\n✗ Mots-clés\n✗ Image\n\nCette action est irréversible.');"
                                               title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="alert alert-info mt-3 mb-0">
            <i class="bi bi-info-circle-fill me-2"></i>
            Total : <strong><?php echo count($articles); ?></strong> article(s)
        </div>
        
    <?php } else { ?>
        <!-- Aucun article -->
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Aucun article pour le moment.
            <a href="create.php" class="alert-link">Créer le premier article</a>
        </div>
    <?php } ?>
    
</div>

<?php require_once '../../../footer.php'; ?>