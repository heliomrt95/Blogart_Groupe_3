<?php
include '../../../header.php';

$numMemb = isset($_GET['numMemb']) ? (int)$_GET['numMemb'] : 0;
if($numMemb == 0) {
    echo "<script>alert('Membre introuvable'); window.location.href='list.php';</script>";
    exit;
}

// Charger le membre avec son statut
$query = "SELECT m.*, s.libStat 
          FROM MEMBRE m 
          LEFT JOIN STATUT s ON m.numStat = s.numStat 
          WHERE m.numMemb = $numMemb";
          
global $DB;
if(!$DB) sql_connect();
$membre = $DB->query($query)->fetch(PDO::FETCH_ASSOC);

if(!$membre) {
    echo "<script>alert('Membre introuvable'); window.location.href='list.php';</script>";
    exit;
}

// Vérifier si c'est un admin
if($membre['libStat'] == 'Administrateur') {
    echo "<script>alert('ERREUR : La suppression du compte Administrateur est INTERDITE !'); window.location.href='list.php';</script>";
    exit;
}
?>

<div class="container my-4">
    <!-- TITRE -->
    <h1 class="text-center mb-4" style="border-top: 3px solid #000; border-bottom: 3px solid #000; padding: 20px 0; font-weight: bold;">
        Suppression Membre
    </h1>
    
    <div class="alert alert-danger">
        <strong>ATTENTION !</strong> La suppression est irréversible. Tous les commentaires et likes de ce membre seront également supprimés.
    </div>
    
    <form action="<?php echo ROOT_URL . '/api/members/delete.php'; ?>" method="post">
        <input type="hidden" name="numMemb" value="<?php echo $membre['numMemb']; ?>">
        
        <!-- Tous les champs DISABLED -->
        <div class="mb-3">
            <label class="form-label">Pseudo</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($membre['pseudoMemb']); ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($membre['prenomMemb']); ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($membre['nomMemb']); ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label class="form-label">eMail</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($membre['eMailMemb']); ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Accord RGPD</label>
            <input type="text" class="form-control" value="<?php echo ($membre['accordMemb'] == 1) ? 'Oui' : 'Non'; ?>" disabled>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Statut</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($membre['libStat']); ?>" disabled>
        </div>
        
        <!-- Boutons -->
        <div class="mt-4">
            <a href="list.php" class="btn btn-primary">List</a>
            <button type="submit" class="btn btn-danger" 
                    onclick="return confirm('Êtes-vous SÛR de vouloir supprimer ce membre ?');">
                Confirmer Delete ?
            </button>
        </div>
    </form>
</div>

<?php include '../../../footer.php'; ?>