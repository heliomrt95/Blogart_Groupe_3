<?php 
require_once '../../header.php';
sql_connect();

// Charger TOUS les articles
$query = "SELECT a.*, t.libThem 
          FROM ARTICLE a 
          LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
          ORDER BY a.numArt DESC";

global $DB;
$articles = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- PAGE ARTICLES -->
<section class="page-articles">
    <div class="container">
        <h1 class="page-title">Articles</h1>
        
        <?php if(count($articles) > 0) { ?>
            <div class="articles-list">
                <?php foreach($articles as $article) { ?>
                    <article class="article-item">
                        <div class="row">
                            <!-- Image à gauche (Bootstrap col) -->
                            <div class="col-lg-5">
                                <div class="article-item-image">
                                    <?php if(!empty($article['urlPhotArt'])) { ?>
                                        <img src="/src/uploads/<?php echo $article['urlPhotArt']; ?>" 
                                             class="img-fluid" alt="Article">
                                    <?php } else { ?>
                                        <img src="https://images.unsplash.com/photo-1590479773265-7464e5d48118?w=600" 
                                             class="img-fluid" alt="Article">
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <!-- Contenu à droite (Bootstrap col) -->
                            <div class="col-lg-7">
                                <div class="article-item-content">
                                    <p class="article-item-meta">
                                        By John Doe | March 12, 2024
                                    </p>
                                    
                                    <h2 class="article-item-title">
                                        <?php echo htmlspecialchars($article['libTitrArt']); ?>
                                    </h2>
                                    
                                    <p class="article-item-excerpt">
                                        Lorem Ipsum Dolor Sit Amet Consectetur. Consectetur Risus Quis Diam Hendrerit. 
                                        Interdum Mattis In Sed Diam Egestas Metus At Duis Commodo. Cursus Quis Cursus 
                                        Dignissim Egestas Sollicitudin Tristique Quis. Orci Neque Quis Porttitor Eu Amet. 
                                        Ommodo. Cursus Quis Cursus Dignissim Egestas Sollicitudin Tristique Quis. Orci 
                                        Neque Quis Porttitor Eu Amet.
                                    </p>
                                    
                                    <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                                       class="btn btn-lire-suite">Lire la suite ...</a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-info">
                Aucun article disponible pour le moment.
            </div>
        <?php } ?>
    </div>
</section>

<?php require_once '../../footer.php'; ?>