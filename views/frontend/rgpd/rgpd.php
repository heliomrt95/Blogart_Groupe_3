<?php
require_once '../../../header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Politique de Confidentialité et RGPD</h1>
            <p class="text-muted">Dernière mise à jour : <?php echo date('d/m/Y'); ?></p>
            
            <hr>
            
            <div class="alert alert-info">
                <strong>Protection de vos données personnelles</strong><br>
                Blog'Art s'engage à protéger la vie privée de ses utilisateurs et à respecter le Règlement Général 
                sur la Protection des Données (RGPD).
            </div>
            
            <h2>1. Responsable du traitement</h2>
            <p>
                <strong>Blog'Art</strong><br>
                Adresse : [Adresse de l'éditeur]<br>
                Email : <a href="mailto:dpo@blogart.fr">dpo@blogart.fr</a><br>
                Téléphone : [Numéro de téléphone]
            </p>
            
            <h2>2. Données collectées</h2>
            <p>
                Dans le cadre de l'utilisation du Site, nous pouvons collecter les données personnelles suivantes :
            </p>
            
            <h3>2.1. Données collectées lors de l'inscription</h3>
            <ul>
                <li><strong>Pseudo</strong> : utilisé pour vous identifier sur le Site</li>
                <li><strong>Prénom et Nom</strong> : pour personnaliser votre compte</li>
                <li><strong>Adresse email</strong> : pour la communication et la récupération de compte</li>
                <li><strong>Mot de passe</strong> : crypté pour sécuriser votre compte</li>
                <li><strong>Date et heure d'inscription</strong> : pour des raisons de traçabilité</li>
                <li><strong>Accord RGPD</strong> : votre consentement explicite à la conservation de vos données</li>
            </ul>
            
            <h3>2.2. Données collectées lors de l'utilisation</h3>
            <ul>
                <li><strong>Commentaires</strong> : texte et date de publication</li>
                <li><strong>Likes</strong> : articles que vous aimez</li>
                <li><strong>Date de dernière modification</strong> : de votre profil</li>
                <li><strong>Cookies</strong> : pour améliorer votre expérience de navigation (voir section 4)</li>
            </ul>
            
            <h2>3. Finalités du traitement</h2>
            <p>
                Vos données personnelles sont collectées et traitées pour les finalités suivantes :
            </p>
            <ul>
                <li><strong>Gestion de votre compte</strong> : création, modification, suppression</li>
                <li><strong>Fonctionnement du Site</strong> : publication de commentaires, gestion des likes</li>
                <li><strong>Communication</strong> : notifications, réponses à vos demandes</li>
                <li><strong>Sécurité</strong> : prévention de la fraude et des abus (reCAPTCHA)</li>
                <li><strong>Amélioration du Site</strong> : statistiques anonymisées d'utilisation</li>
                <li><strong>Obligations légales</strong> : respect de la législation en vigueur</li>
            </ul>
            
            <h2>4. Cookies</h2>
            
            <h3>4.1. Qu'est-ce qu'un cookie ?</h3>
            <p>
                Un cookie est un petit fichier texte déposé sur votre terminal lors de la visite d'un site web. 
                Il permet au site de se souvenir de vos actions et préférences.
            </p>
            
            <h3>4.2. Types de cookies utilisés</h3>
            <ul>
                <li><strong>Cookies de session</strong> : indispensables au fonctionnement du Site (connexion, panier)</li>
                <li><strong>Cookies de préférence</strong> : mémorisation de vos préférences (langue, affichage)</li>
                <li><strong>Cookies de sécurité</strong> : protection contre les attaques (reCAPTCHA de Google)</li>
            </ul>
            
            <h3>4.3. Gestion des cookies</h3>
            <p>
                Vous pouvez à tout moment choisir de désactiver les cookies dans les paramètres de votre navigateur. 
                Cependant, cela peut affecter le fonctionnement du Site.
            </p>
            <p>
                Lors de votre première visite, une bannière vous informe de l'utilisation des cookies et vous permet 
                d'accepter ou de refuser leur dépôt.
            </p>
            
            <h2>5. Base légale du traitement</h2>
            <p>
                Le traitement de vos données personnelles repose sur :
            </p>
            <ul>
                <li><strong>Votre consentement explicite</strong> : accord RGPD lors de l'inscription</li>
                <li><strong>L'exécution du contrat</strong> : fourniture des services du Site</li>
                <li><strong>Intérêt légitime</strong> : sécurité et amélioration du Site</li>
                <li><strong>Obligations légales</strong> : conservation pour raisons juridiques</li>
            </ul>
            
            <h2>6. Durée de conservation</h2>
            <p>
                Vos données personnelles sont conservées pendant :
            </p>
            <ul>
                <li><strong>Données de compte</strong> : pendant toute la durée de votre inscription + 1 an après suppression</li>
                <li><strong>Commentaires</strong> : jusqu'à suppression par vous-même ou un modérateur</li>
                <li><strong>Logs de connexion</strong> : 12 mois maximum</li>
                <li><strong>Cookies</strong> : 13 mois maximum</li>
            </ul>
            
            <h2>7. Destinataires des données</h2>
            <p>
                Vos données personnelles sont destinées :
            </p>
            <ul>
                <li><strong>En interne</strong> : administrateurs et modérateurs du Site</li>
                <li><strong>En externe</strong> : hébergeur du Site (OVH, France)</li>
                <li><strong>Services tiers</strong> : Google reCAPTCHA (protection anti-spam)</li>
            </ul>
            <p>
                Nous ne vendons, ne louons ni ne partageons vos données à des tiers à des fins commerciales.
            </p>
            
            <h2>8. Transfert hors UE</h2>
            <p>
                Certains services tiers (comme Google reCAPTCHA) peuvent impliquer un transfert de données hors de 
                l'Union Européenne. Ces transferts sont encadrés par des garanties appropriées (clauses contractuelles 
                types, Privacy Shield).
            </p>
            
            <h2>9. Sécurité des données</h2>
            <p>
                Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données :
            </p>
            <ul>
                <li><strong>Cryptage des mots de passe</strong> : hachage avec password_hash()</li>
                <li><strong>Connexion sécurisée</strong> : HTTPS</li>
                <li><strong>Accès restreint</strong> : seuls les administrateurs autorisés</li>
                <li><strong>Sauvegardes régulières</strong> : pour prévenir la perte de données</li>
                <li><strong>Protection anti-robots</strong> : reCAPTCHA v3</li>
            </ul>
            
            <h2>10. Vos droits RGPD</h2>
            <p>
                Conformément au RGPD, vous disposez des droits suivants :
            </p>
            
            <h3>10.1. Droit d'accès</h3>
            <p>
                Vous pouvez demander une copie de toutes les données personnelles que nous détenons sur vous.
            </p>
            
            <h3>10.2. Droit de rectification</h3>
            <p>
                Vous pouvez modifier vos données personnelles directement depuis votre compte ou nous demander de les corriger.
            </p>
            
            <h3>10.3. Droit à l'effacement ("droit à l'oubli")</h3>
            <p>
                Vous pouvez supprimer votre compte à tout moment. Cela entraînera la suppression de toutes vos données 
                personnelles et de vos commentaires.
            </p>
            
            <h3>10.4. Droit à la limitation du traitement</h3>
            <p>
                Vous pouvez demander la limitation du traitement de vos données dans certaines circonstances.
            </p>
            
            <h3>10.5. Droit à la portabilité</h3>
            <p>
                Vous pouvez demander à recevoir vos données dans un format structuré et couramment utilisé.
            </p>
            
            <h3>10.6. Droit d'opposition</h3>
            <p>
                Vous pouvez vous opposer à tout moment au traitement de vos données pour des raisons tenant à votre 
                situation particulière.
            </p>
            
            <h3>10.7. Droit de retirer votre consentement</h3>
            <p>
                Vous pouvez retirer votre consentement au traitement de vos données à tout moment en supprimant votre compte.
            </p>
            
            <h3>10.8. Exercice de vos droits</h3>
            <p>
                Pour exercer vos droits, vous pouvez :
            </p>
            <ul>
                <li>Modifier vos informations directement dans votre compte</li>
                <li>Nous contacter à : <a href="mailto:dpo@blogart.fr">dpo@blogart.fr</a></li>
                <li>Nous écrire à : [Adresse postale]</li>
            </ul>
            <p>
                Nous nous engageons à répondre à votre demande dans un délai d'un mois maximum.
            </p>
            
            <h2>11. Droit de réclamation</h2>
            <p>
                Si vous estimez que vos droits ne sont pas respectés, vous pouvez introduire une réclamation auprès 
                de la Commission Nationale de l'Informatique et des Libertés (CNIL) :
            </p>
            <p>
                <strong>CNIL</strong><br>
                3 Place de Fontenoy - TSA 80715<br>
                75334 PARIS CEDEX 07<br>
                Tél. : 01 53 73 22 22<br>
                Site web : <a href="https://www.cnil.fr" target="_blank">www.cnil.fr</a>
            </p>
            
            <h2>12. Modifications de la politique de confidentialité</h2>
            <p>
                Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. 
                Toute modification sera publiée sur cette page avec une nouvelle date de mise à jour. 
                Nous vous encourageons à consulter régulièrement cette page.
            </p>
            
            <h2>13. Mentions légales</h2>
            <p>
                <strong>Éditeur du site :</strong><br>
                Blog'Art<br>
                [Adresse]<br>
                [Forme juridique et capital social]<br>
                [Numéro SIRET]<br>
                Directeur de publication : [Nom]
            </p>
            <p>
                <strong>Hébergeur :</strong><br>
                OVH SAS<br>
                2 rue Kellermann - 59100 Roubaix - France<br>
                Tél. : 1007<br>
                Site web : <a href="https://www.ovh.com" target="_blank">www.ovh.com</a>
            </p>
            
            <hr>
            
            <h2>Contact</h2>
            <p>
                Pour toute question concernant cette politique de confidentialité ou l'utilisation de vos données 
                personnelles, vous pouvez nous contacter :
            </p>
            <p>
                Email : <a href="mailto:dpo@blogart.fr">dpo@blogart.fr</a><br>
                Téléphone : [Numéro]<br>
                Adresse : [Adresse complète]
            </p>
            
            <div class="mt-4">
                <a href="<?php echo ROOT_URL; ?>" class="btn btn-primary">Retour à l'accueil</a>
                <a href="cgu.php" class="btn btn-secondary">Consulter les CGU</a>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../footer.php';
?>