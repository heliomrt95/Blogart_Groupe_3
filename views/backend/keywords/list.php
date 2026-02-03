<?php
// Inclusion du fichier header qui contient le layout général et l'accès à la configuration
include '../../../header.php';

// Récupération de tous les mots-clés depuis la table MOTCLE
$motcles = sql_select("MOTCLE", "*");
?>

<!-- Structure Bootstrap pour afficher la liste des mots-clés -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre de la page -->
            <h1>Mots-clés</h1>
            <!-- Tableau Bootstrap pour afficher les mots-clés -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Libellé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Boucle sur chaque mot-clé pour afficher une ligne du tableau -->
                    <?php foreach($motcles as $motcle){ ?>
                        <tr>
                            <!-- Affichage de l'ID du mot-clé -->
                            <td><?php echo($motcle['numMotCle']); ?></td>
                            <!-- Affichage du libellé du mot-clé -->
                            <td><?php echo($motcle['libMotCle']); ?></td>
                            <!-- Boutons d'actions : Éditer et Supprimer -->
                            <td>
                                <!-- Lien vers la page d'édition avec l'ID du mot-clé en paramètre -->
                                <a href="edit.php?numMotCle=<?php echo($motcle['numMotCle']); ?>" class="btn btn-primary">Edit</a>
                                <!-- Lien vers la page de suppression avec l'ID du mot-clé en paramètre -->
                                <a href="delete.php?numMotCle=<?php echo($motcle['numMotCle']); ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Bouton pour créer un nouveau mot-clé -->
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
<?php
// Inclusion du fichier footer qui contient la fermeture du layout général
include '../../../footer.php';
?>