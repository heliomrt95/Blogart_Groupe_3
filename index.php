<?php 
require_once 'header.php';

sql_connect();

// Charger les 3 derniers articles
$query = "SELECT a.*, t.libThem 
          FROM ARTICLE a 
          LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
          ORDER BY a.numArt DESC 
          LIMIT 3";

global $DB;
$articles = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>



<!-- HERO SECTION --><!-- HERO SECTION --><!-- HERO SECTION --><!-- HERO SECTION -->
<section class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Les quais de Bordeaux, au fil de la Garonne</h1>
            <p class="hero-text">
                Les quais de Bordeaux sont un lieu emblématique entre fleuve, histoire et vie urbaine. 
                Ils offrent un espace de promenade, de culture et de rencontres au cœur de la ville. 
                À travers ce blog, découvrez des articles, des photos et des anecdotes pour explorer 
                les quais autrement.
            </p>
            <a href="/views/frontend/articles.php" class="btn btn-decouvrir">Découvrir</a>
        </div>
    </div>
</section>

<!-- SECTION DERNIÈRES -->
<section class="section-dernieres">
    <div class="container">
        <h2 class="mb-4">Dernières</h2>
        
        <?php if(count($articles) >= 3): ?>
            <div class="articles-container">
                
                <!-- ARTICLE GAUCHE (grand) -->
                <div class="article-left">
                    <?php $article = $articles[0]; ?>
                    
                    <?php if(!empty($article['urlPhotArt'])): ?>
                        <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                             alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>" 
                             class="img-fluid">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1590479773265-7464e5d48118?w=600" 
                             alt="Article" 
                             class="img-fluid">
                    <?php endif; ?>
                    
                    <p class="meta mb-2">
                        By Rédaction LEKÉ | 
                        <?php 
                        if (!empty($article['dtCreaArt'])) {
                            echo date('F d, Y', strtotime($article['dtCreaArt']));
                        } else {
                            echo date('F d, Y');
                        }
                        ?>
                    </p>
                    
                    <h3 class="mb-3"><?php echo htmlspecialchars($article['libTitrArt']); ?></h3>
                    
                    <p class="excerpt mb-3">
                        <?php 
                        $chapo = $article['libChapoArt'];
                        if (strlen($chapo) > 200) {
                            echo htmlspecialchars(substr($chapo, 0, 200)) . '...';
                        } else {
                            echo htmlspecialchars($chapo);
                        }
                        ?>
                    </p>
                    
                    <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                       class="btn btn-lire-plus">En lire plus</a>
                </div>
                
                <!-- ARTICLES DROITE (2 petits) -->
                <div class="articles-right">
                    
                    <!-- Article 2 -->
                    <?php $article = $articles[1]; ?>
                    <div class="article-right-item">
                        <div class="article-right-top">
                            <?php if(!empty($article['urlPhotArt'])): ?>
                                <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                                     alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1581625875212-c59bb6d69148?w=300" 
                                     alt="Article">
                            <?php endif; ?>
                            
                            <div class="article-right-header">
                                <p class="meta mb-2">
                                    By Rédaction LEKÉ | 
                                    <?php 
                                    if (!empty($article['dtCreaArt'])) {
                                        echo date('F d, Y', strtotime($article['dtCreaArt']));
                                    } else {
                                        echo date('F d, Y');
                                    }
                                    ?>
                                </p>
                                <h4><?php echo htmlspecialchars($article['libTitrArt']); ?></h4>
                            </div>
                        </div>
                        
                        <div class="article-right-bottom">
                            <p class="excerpt">
                                <?php 
                                $chapo = $article['libChapoArt'];
                                if (strlen($chapo) > 150) {
                                    echo htmlspecialchars(substr($chapo, 0, 150)) . '...';
                                } else {
                                    echo htmlspecialchars($chapo);
                                }
                                ?>
                            </p>
                            <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                               class="btn btn-lire-plus">En lire plus</a>
                        </div>
                    </div>
                    
                    <!-- Article 3 -->
                    <?php $article = $articles[2]; ?>
                    <div class="article-right-item">
                        <div class="article-right-top">
                            <?php if(!empty($article['urlPhotArt'])): ?>
                                <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                                     alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=300" 
                                     alt="Article">
                            <?php endif; ?>
                            
                            <div class="article-right-header">
                                <p class="meta mb-2">
                                    By Rédaction LEKÉ | 
                                    <?php 
                                    if (!empty($article['dtCreaArt'])) {
                                        echo date('F d, Y', strtotime($article['dtCreaArt']));
                                    } else {
                                        echo date('F d, Y');
                                    }
                                    ?>
                                </p>
                                <h4><?php echo htmlspecialchars($article['libTitrArt']); ?></h4>
                            </div>
                        </div>
                        
                        <div class="article-right-bottom">
                            <p class="excerpt">
                                <?php 
                                $chapo = $article['libChapoArt'];
                                if (strlen($chapo) > 150) {
                                    echo htmlspecialchars(substr($chapo, 0, 150)) . '...';
                                } else {
                                    echo htmlspecialchars($chapo);
                                }
                                ?>
                            </p>
                            <a href="/views/frontend/article.php?id=<?php echo $article['numArt']; ?>" 
                               class="btn btn-lire-plus">En lire plus</a>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        <?php elseif(count($articles) > 0): ?>
            <div class="alert alert-info">
                Il y a <?php echo count($articles); ?> article(s) dans la base. Il en faut au moins 3 pour afficher cette section.
                <a href="/views/backend/articles/create.php" class="alert-link">Créer plus d'articles</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                Aucun article pour le moment. 
                <a href="/views/backend/articles/create.php" class="alert-link">Créer votre premier article</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- NOTRE ÉQUIPE -->
<section class="section-equipe">
    <div class="container">
        <h2 class="mb-4">Notre équipe</h2>
        
        <div class="team-grid">
            <!-- Membre 1 - Tom WILLIOT -->
            <div class="team-member">
                <div class="team-avatar">
                    <img src="/src/images/equipe/tom.jpg" alt="Tom WILLIOT">
                </div>
                <h3 class="team-name">Tom WILLIOT</h3>
                <p class="team-role">Blogeur</p>
                <p class="team-description">Rédacteur en chef</p>
            </div>
            
            <!-- Membre 2 - Remi SOULARD -->
            <div class="team-member">
                <div class="team-avatar">
                    <img src="/src/images/equipe/remi.jpg" alt="Remi SOULARD">
                </div>
                <h3 class="team-name">Remi SOULARD</h3>
                <p class="team-role">Blogeur</p>
                <p class="team-description">Rédacteur adjoint</p>
            </div>
            
            <!-- Membre 3 - Helio MARTONE -->
            <div class="team-member">
                <div class="team-avatar">
                    <img src="/src/images/equipe/helio.jpg" alt="Helio MARTONE">
                </div>
                <h3 class="team-name">Helio MARTONE</h3>
                <p class="team-role">Blogeur</p>
                <p class="team-description">Directeur des opérations de développement</p>
            </div>
            
            <!-- Membre 4 - Khalid LOTF -->
            <div class="team-member">
                <div class="team-avatar">
                    <img src="/src/images/equipe/khalid.jpg" alt="Khalid LOTF">
                </div>
                <h3 class="team-name">Khalid LOTF</h3>
                <p class="team-role">Blogeur</p>
                <p class="team-description">Développeur web et rédacteur adjoint</p>
            </div>
        </div>
    </div>
</section>

<!-- LOCALISATION -->
<section class="section-localisation">
    <div class="container">
        <h2 class="mb-4">Localisation</h2>
        
        <div class="localisation-content">
            <!-- MAP à gauche -->
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22797.88984935826!2d-0.5871524!3d44.8404400!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5527e8f751ca81%3A0x796386037b397a89!2sBordeaux!5e0!3m2!1sfr!2sfr!4v1234567890" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <!-- TEXTE à droite -->
            <div class="localisation-text">
                <h3>Un périmètre d’étude de Bacalan aux Chartrons</h3>
                
                <p>
                    L’actualité traitée ici se concentre sur la rive gauche, couvrant l’axe fluvial de Bacalan au centre-ville. Nous suivons l’évolution urbaine des Bassins à flot et des Chartrons, points névralgiques du dynamisme bordelais.
                </p>
                
                <p>
                    Ce champ d’observation s’étend vers Bordeaux-Lac et intègre les espaces limitrophes comme le Jardin Public. Cette délimitation permet une information rigoureuse, ancrée dans la réalité quotidienne de ces quartiers en mutation.
                </p>
                
                <a href="/views/frontend/articles.php" class="btn btn-explorer">Explorer</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>