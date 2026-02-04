<?php 
require_once '../../header.php';
sql_connect();

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if (!empty($searchQuery)) {
    // Recherche dans les articles
    $query = "SELECT a.*, t.libThem 
              FROM ARTICLE a 
              LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
              WHERE a.libTitrArt LIKE :search 
                 OR a.libChapoArt LIKE :search 
                 OR a.parag1Art LIKE :search
              ORDER BY a.dtCreaArt DESC
              LIMIT 20";
    
    global $DB;
    $stmt = $DB->prepare($query);
    $searchParam = '%' . $searchQuery . '%';
    $stmt->execute(['search' => $searchParam]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <h1 class="display-5 fw-bold mb-4">Rechercher</h1>
            <hr class="mb-5">
            
            <!-- Formulaire -->
            <form method="GET" action="/views/frontend/search.php" class="mb-5">
                <div class="input-group input-group-lg">
                    <span class="input-group-text" style="background-color: white;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="q" 
                           value="<?php echo htmlspecialchars($searchQuery); ?>" 
                           placeholder="Rechercher un article sur les quais..." 
                           autofocus>
                    <button class="btn" type="submit" style="background-color: #2F509E; color: white;">
                        Rechercher
                    </button>
                </div>
            </form>
            
            <?php if (!empty($searchQuery)): ?>
                
                <div class="mb-4">
                    <h2 class="h4 fw-bold mb-4">
                        <?php if (count($results) > 0): ?>
                            <?php echo count($results); ?> résultat<?php echo count($results) > 1 ? 's' : ''; ?> 
                            pour "<?php echo htmlspecialchars($searchQuery); ?>"
                        <?php else: ?>
                            Aucun résultat pour "<?php echo htmlspecialchars($searchQuery); ?>"
                        <?php endif; ?>
                    </h2>
                </div>
                
                <?php if (count($results) > 0): ?>
                    <div class="row g-4">
                        <?php foreach ($results as $article): ?>
                            <div class="col-12">
                                <div class="card border-0" style="background-color: #f8f9fa;">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <?php if (!empty($article['urlPhotArt'])): ?>
                                                <div class="col-md-3">
                                                    <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                                                         class="img-fluid rounded" 
                                                         alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>"
                                                         style="height: 120px; width: 100%; object-fit: cover;">
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="<?php echo !empty($article['urlPhotArt']) ? 'col-md-9' : 'col-12'; ?>">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <?php if (!empty($article['libThem'])): ?>
                                                        <span class="badge" style="background-color: #2F509E;">
                                                            <?php echo htmlspecialchars($article['libThem']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    <span class="text-muted small">
                                                        <?php echo date('d/m/Y', strtotime($article['dtCreaArt'])); ?>
                                                    </span>
                                                </div>
                                                
                                                <h3 class="h5 fw-bold mb-2">
                                                    <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                                                       class="text-decoration-none text-dark">
                                                        <?php echo htmlspecialchars($article['libTitrArt']); ?>
                                                    </a>
                                                </h3>
                                                
                                                <p class="text-muted mb-3">
                                                    <?php 
                                                    $excerpt = strip_tags($article['libChapoArt']);
                                                    echo htmlspecialchars(substr($excerpt, 0, 150)) . '...'; 
                                                    ?>
                                                </p>
                                                
                                                <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                                                   class="btn btn-sm" style="background-color: #2F509E; color: white;">
                                                    Lire l'article
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Aucun résultat trouvé.</strong>
                        <p class="mb-0 mt-2">
                            Essayez avec d'autres mots-clés ou consultez tous les 
                            <a href="/views/frontend/articles.php" style="color: #2F509E;">articles disponibles</a>.
                        </p>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="background-color: #f8f9fa;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 3rem;">🌊</div>
                                <h3 class="h5 fw-bold mb-2">Les quais</h3>
                                <p class="text-muted small mb-3">Découvrez la transformation des quais</p>
                                <a href="?q=quais" class="btn btn-sm" style="background-color: #2F509E; color: white;">
                                    Rechercher
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="background-color: #f8f9fa;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 3rem;">🎨</div>
                                <h3 class="h5 fw-bold mb-2">Événements</h3>
                                <p class="text-muted small mb-3">Les festivals et animations</p>
                                <a href="?q=événements" class="btn btn-sm" style="background-color: #2F509E; color: white;">
                                    Rechercher
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="background-color: #f8f9fa;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 3rem;">🏛️</div>
                                <h3 class="h5 fw-bold mb-2">Histoire</h3>
                                <p class="text-muted small mb-3">2000 ans d'histoire bordelaise</p>
                                <a href="?q=histoire" class="btn btn-sm" style="background-color: #2F509E; color: white;">
                                    Rechercher
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?php require_once '../../footer.php'; ?>