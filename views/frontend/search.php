<?php
// Page de recherche frontend
// Ce fichier affiche un formulaire de recherche et liste les articles correspondants.

// Inclut l'en-tête commun (navigation, sessions, etc.)
require_once '../../header.php';

// Initialise la connexion SQL si besoin (fonction définie ailleurs)
sql_connect();

// Récupère la requête de recherche depuis le paramètre GET 'q'
// Utilise trim() pour supprimer les espaces superflus
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

// Tableau qui contiendra les résultats de la recherche
$results = [];

// Si l'utilisateur a saisi quelque chose, on exécute la recherche
if (!empty($searchQuery)) {
    // Prépare la requête SQL qui recherche le terme dans le titre, le chapo ou le premier paragraphe
    // Utilise une jointure LEFT JOIN pour récupérer le nom de thématique si présent
    $query = "SELECT a.*, t.libThem 
              FROM ARTICLE a 
              LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
              WHERE a.libTitrArt LIKE :search 
                 OR a.libChapoArt LIKE :search 
                 OR a.parag1Art LIKE :search
              ORDER BY a.dtCreaArt DESC
              LIMIT 20";

    // Accès à la variable PDO globale définie par l'application
    global $DB;
    // Prépare la requête pour éviter les injections SQL
    $stmt = $DB->prepare($query);
    // On enveloppe la recherche avec des % pour la recherche partielle
    $searchParam = '%' . $searchQuery . '%';
    // Exécute la requête en liant le paramètre nommé ':search'
    $stmt->execute(['search' => $searchParam]);
    // Récupère tous les résultats sous forme de tableaux associatifs
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <h1 class="display-5 fw-bold mb-4">Rechercher</h1>
            <hr class="mb-5">
            
            <!-- Formulaire : envoi GET vers cette page, paramètre 'q' contenant le terme recherché -->
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
            
            <!-- Si une requête de recherche est présente, afficher le récapitulatif et les résultats -->
            <?php if (!empty($searchQuery)) { ?>

                <!-- En-tête indiquant le nombre de résultats pour la recherche -->
                <div class="mb-4">
                    <h2 class="h4 fw-bold mb-4">
                        <?php if (count($results) > 0) { ?>
                            <?php echo count($results); ?> résultat<?php echo count($results) > 1 ? 's' : ''; ?> 
                            pour "<?php echo htmlspecialchars($searchQuery); ?>"
                        <?php } else { ?>
                            Aucun résultat pour "<?php echo htmlspecialchars($searchQuery); ?>"
                        <?php } ?>
                    </h2>
                </div>

                <?php if (count($results) > 0) { ?>
                    <div class="row g-4">
                        <?php foreach ($results as $article) { ?>
                            <div class="col-12">
                                <div class="card border-0" style="background-color: #f8f9fa;">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center">
                                            <?php // Affiche la vignette de l'article si une image est renseignée ?>
                                            <?php if (!empty($article['urlPhotArt'])) { ?>
                                                <div class="col-md-3">
                                                    <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                                                         class="img-fluid rounded" 
                                                         alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>"
                                                         style="height: 120px; width: 100%; object-fit: cover;">
                                                </div>
                                            <?php } ?>

                                            <div class="<?php echo !empty($article['urlPhotArt']) ? 'col-md-9' : 'col-12'; ?>">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <?php // Affiche la thématique si disponible ?>
                                                    <?php if (!empty($article['libThem'])) { ?>
                                                        <span class="badge" style="background-color: #2F509E;">
                                                            <?php echo htmlspecialchars($article['libThem']); ?>
                                                        </span>
                                                    <?php } ?>
                                                    <?php // Affiche la date de création formatée en JJ/MM/AAAA ?>
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

                                                <?php // Extrait (chapo) : suppression des balises HTML puis troncature à 150 caractères ?>
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
                        <?php } ?>
                    </div>

                <?php } else { ?>
                    <!-- Message affiché si la recherche n'a retourné aucun résultat -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Aucun résultat trouvé.</strong>
                        <p class="mb-0 mt-2">
                            Essayez avec d'autres mots-clés ou consultez tous les 
                            <a href="/views/frontend/articles.php" style="color: #2F509E;">articles disponibles</a>.
                        </p>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <!-- Pas de recherche saisie : affichage de suggestions thématiques cliquables -->
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
            <?php } ?>
            
        </div>
    </div>
</div>

<?php require_once '../../footer.php'; ?>