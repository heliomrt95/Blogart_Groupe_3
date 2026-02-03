<?php
include '../../../header.php';

// Charger les statuts
$statuts = sql_select("STATUT", "*");
?>

<div class="container my-4">
    <!-- TITRE -->
    <h1 class="text-center mb-4" style="border-top: 3px solid #000; border-bottom: 3px solid #000; padding: 20px 0; font-weight: bold;">
        Création nouveau Membre
    </h1>
    
    <form action="<?php echo ROOT_URL . '/api/members/create.php'; ?>" method="post">
        
        <!-- Pseudo -->
        <div class="mb-3">
            <label for="pseudoMemb" class="form-label">Pseudo (non modifiable)</label>
            <input type="text" id="pseudoMemb" name="pseudoMemb" class="form-control" 
                   maxlength="70" required>
            <small class="text-muted">(Entre 6 et 70 car.)</small>
        </div>
        
        <!-- Prénom -->
        <div class="mb-3">
            <label for="prenomMemb" class="form-label">Prénom</label>
            <input type="text" id="prenomMemb" name="prenomMemb" class="form-control" 
                   maxlength="30" required>
        </div>
        
        <!-- Nom -->
        <div class="mb-3">
            <label for="nomMemb" class="form-label">Nom</label>
            <input type="text" id="nomMemb" name="nomMemb" class="form-control" 
                   maxlength="30" required>
        </div>
        
        <!-- Password -->
        <div class="mb-3">
            <label for="passMemb" class="form-label">Password</label>
            <input type="password" id="passMemb" name="passMemb" class="form-control" 
                   minlength="8" maxlength="15" required>
            <small class="text-muted">(Entre 8 et 15 car., au - une majuscule, une minuscule, un chiffre, car. spéciaux acceptés)</small>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="showPass1" 
                       onclick="document.getElementById('passMemb').type = this.checked ? 'text' : 'password';">
                <label class="form-check-label" for="showPass1">Afficher Mot de passe</label>
            </div>
        </div>
        
        <!-- Confirmez password -->
        <div class="mb-3">
            <label for="passMemb2" class="form-label">Confirmez password</label>
            <input type="password" id="passMemb2" name="passMemb2" class="form-control" 
                   minlength="8" maxlength="15" required>
            <small class="text-muted">(Entre 8 et 15 car., au - une majuscule, une minuscule, un chiffre, car. spéciaux acceptés)</small>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="showPass2" 
                       onclick="document.getElementById('passMemb2').type = this.checked ? 'text' : 'password';">
                <label class="form-check-label" for="showPass2">Afficher Mot de passe</label>
            </div>
        </div>
        
        <!-- eMail -->
        <div class="mb-3">
            <label for="eMailMemb" class="form-label">eMail</label>
            <input type="email" id="eMailMemb" name="eMailMemb" class="form-control" 
                   maxlength="70" required>
        </div>
        
        <!-- Confirmez eMail -->
        <div class="mb-3">
            <label for="eMailMemb2" class="form-label">Confirmez eMail</label>
            <input type="email" id="eMailMemb2" name="eMailMemb2" class="form-control" 
                   maxlength="70" required>
        </div>
        
        <!-- Accord RGPD -->
        <div class="mb-3">
            <label class="form-label">Accord RGPD (obligatoire)</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="accordMemb" id="rgpdOui" value="1" required>
                <label class="form-check-label" for="rgpdOui">Oui</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="accordMemb" id="rgpdNon" value="0">
                <label class="form-check-label" for="rgpdNon">Non</label>
            </div>
        </div>
        
        <!-- Statut -->
        <div class="mb-3">
            <label for="numStat" class="form-label">Statut</label>
            <select id="numStat" name="numStat" class="form-control" required>
                <option value="">Choisissez un statut</option>
                <?php foreach($statuts as $statut): ?>
                    <option value="<?php echo $statut['numStat']; ?>">
                        <?php echo htmlspecialchars($statut['libStat']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Boutons -->
        <div class="mt-4">
            <a href="list.php" class="btn btn-primary">List</a>
            <button type="submit" class="btn btn-outline-success">Create</button>
        </div>
    </form>
</div>

<?php include '../../../footer.php'; ?>