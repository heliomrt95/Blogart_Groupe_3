<?php
// --- Début PHP : préparation des données à afficher dans le formulaire ---

// On inclut le fichier header qui contient la configuration et la connexion à la BDD.
// Sans cela, ROOT_URL et les fonctions comme sql_select ne seraient pas disponibles.
include '../../../header.php';

// Vérifie si l'URL contient ?numStat=xxx et que la valeur est bien un nombre.
// Cela évite les erreurs si on ouvre la page sans paramètre ou avec une valeur invalide.
if (isset($_GET['numStat']) && is_numeric($_GET['numStat'])) {
    // Convertit la valeur GET en entier (sécurité et format clair)
    $numStat = (int) $_GET['numStat'];

    // Appelle la fonction sql_select pour récupérer les données du statut en base.
    // Ici on demande numStat, libStat et dtCreaStat pour remplir le formulaire.
    $statut = sql_select("STATUT", "numStat, libStat, dtCreaStat", "numStat = $numStat");

    // Si la requête a renvoyé au moins une ligne, on extrait les valeurs.
    if (!empty($statut)) {
        // libellé du statut (ex: "Administrateur")
        $libStat = $statut[0]['libStat'];
        // date de création du statut (format SQL, ex: 2023-02-19 16:15:59)
        $dtCreaStat = $statut[0]['dtCreaStat'];
    } else {
        // Si l'id fourni n'existe pas en base, on renvoie vers la page de liste.
        header('Location: list.php');
        exit; // on stoppe l'exécution pour éviter d'afficher la page
    }
} else {
    // Si il n'y a pas de numStat dans l'URL, on renvoie aussi vers la liste.
    header('Location: list.php');
    exit;
}

// --- Fin PHP : les variables $numStat, $libStat et $dtCreaStat sont prêtes ---
?>

<!-- Début HTML : formulaire Bootstrap simple pour modifier un statut -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre visible en haut de la page -->
            <h1>Modification Statut</h1>
            <hr>
        </div>
        <div class="col-md-12">
            <!-- Le formulaire envoie les données en POST vers api/statuts/update.php -->
            <form action="<?php echo ROOT_URL . '/api/statuts/update.php' ?>" method="post">
                <!--
                    Ce champ caché contient l'identifiant original ($numStat).
                    Il est utilisé côté serveur pour retrouver la ligne à modifier
                    même si l'utilisateur change la valeur du champ "numStat".
                -->
                <input type="hidden" name="oldNumStat" value="<?php echo $numStat; ?>" />
                
                <!-- Bloc pour le numéro -->
                <div class="form-group mb-3">
                    <label for="numStat">Numéro</label>
                    <!-- Champ modifiable pour le numéro. required = le navigateur demandera une valeur -->
                    <input id="numStat" name="numStat" class="form-control" type="number" value="<?php echo $numStat; ?>" required />
                    <!-- Explication pour toi : ce champ permet de changer le numéro si besoin. -->
                </div>

                <!-- Bloc pour la date de création -->
                <div class="form-group mb-3">
                    <label for="dtCreaStat">Date création</label>
                    <!--
                        input type=datetime-local attend une valeur au format "YYYY-MM-DDTHH:MM:SS"
                        on transforme la date SQL (ex: "2023-02-19 16:15:59") avec PHP date(...)
                    -->
                    <input id="dtCreaStat" name="dtCreaStat" class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i:s', strtotime($dtCreaStat)); ?>" required />
                    <!-- Explication: change la date si nécessaire, par ex pour corriger une erreur. -->
                </div>

                <!-- Bloc pour le libellé -->
                <div class="form-group mb-3">
                    <label for="libStat">Libellé</label>
                    <!-- htmlspecialchars empêche l'injection de code HTML/JS dans la page -->
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo htmlspecialchars($libStat, ENT_QUOTES, 'UTF-8'); ?>" required />
                    <!-- Explication: ici on écrit le nom du statut (ex: "Modérateur"). -->
                </div>

                <br />
                <!-- Boutons d'action -->
                <div class="form-group mt-2">
                    <!-- Retour à la liste sans envoyer le formulaire -->
                    <a href="list.php" class="btn btn-outline-primary">List</a>
                    <!-- Envoie le formulaire vers update.php pour appliquer la modification -->
                    <button type="submit" class="btn btn-outline-dark">Confirmer Edit ?</button>
                </div>
            </form>
        </div>
    </div>
</div>