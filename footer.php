<!-- FOOTER BOOTSTRAP - BLEU FONCÉ #2F509E - RESPONSIVE -->
<footer class="text-white py-5" style="background-color: #2F509E;">
    <div class="container">
        
        <!-- VERSION DESKTOP (>= 768px) -->
        <div class="row g-4 d-none d-md-flex">
            
            <!-- Colonne 1 : Logo -->
            <div class="col-md-3">
                <img src="/src/images/logo.png" alt="LEKÉ" height="100" class="me-2">
            </div>
            
            <!-- Colonne 2 : À propos -->
            <div class="col-md-3">
                <h5 class="fw-semibold mb-3">À propos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/index.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                            Accueil
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/views/frontend/articles.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                            Articles
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Colonne 3 : Informations -->
            <div class="col-md-3">
                <h5 class="fw-semibold mb-3">Informations</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/views/frontend/rgpd/droit-auteur.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                            Droit d'auteur
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/views/frontend/rgpd/mentions-legales.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                            Mentions légales
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/views/frontend/rgpd/politique-confidentialite.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                            Politique de confidentialité
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/views/frontend/rgpd/gestion-cookies.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                            Gestion des cookies
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Colonne 4 : Contact + Réseaux -->
            <div class="col-md-3">
                <h5 class="fw-semibold mb-3">Nous contacter</h5>
                <p class="mb-3">
                    <a href="mailto:leke2bordeaux@mmi.com" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Email<br>
                        leke2bordeaux@mmi.com
                    </a>
                </p>
                
                <h6 class="fw-semibold mb-3">Réseaux sociaux</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            
        </div>
        
        <!-- VERSION MOBILE (< 768px) - LAYOUT CENTRÉ -->
        <div class="d-md-none text-center">
            
            <!-- Logo centré -->
            <div class="mb-4">
                <img src="/src/images/logo.png" alt="LEKÉ";">
            </div>
            
            <!-- À propos -->
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">À propos</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="/index.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Accueil
                    </a>
                    <a href="/views/frontend/articles.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Articles
                    </a>
                </div>
            </div>
            
            <!-- Informations -->
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">Informations</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="/views/frontend/rgpd/droit-auteur.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Droit d'auteur
                    </a>
                    <a href="/views/frontend/rgpd/mentions-legales.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Mentions légales
                    </a>
                    <a href="/views/frontend/rgpd/politique-confidentialite.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Politique de confidentialité
                    </a>
                    <a href="/views/frontend/rgpd/gestion-cookies.php" class="text-white text-decoration-none" style="opacity: 0.85;">
                        Gestion des cookies
                    </a>
                </div>
            </div>
            
            <!-- Nous contacter -->
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">Nous contacter</h5>
                <a href="mailto:leke2bordeaux@mmi.com" class="text-white text-decoration-none d-block" style="opacity: 0.85;">
                    leke2bordeaux@mmi.com
                </a>
            </div>
            
            <!-- Réseaux sociaux -->
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">Réseaux sociaux</h5>
                <div class="d-flex gap-4 justify-content-center">
                    <a href="#" class="text-white" style="font-size: 2rem;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-white" style="font-size: 2rem;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-white" style="font-size: 2rem;">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="text-white" style="font-size: 2rem;">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
            
        </div>
        
        <!-- Divider -->
        <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
        
        <!-- Copyright -->
        <div class="text-center">
            <small style="opacity: 0.7;">© 2026 LEKÉ | MMI28</small>
        </div>
    </div>
</footer>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>