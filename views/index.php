<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Projets ENSAK</title>
    <link rel="stylesheet" href="style.css"> <!-- adapte selon ton style existant -->
</head>
<body>
    <h1>Bienvenue sur la plateforme Projets ENSAK</h1>

    <?php if(isset($_SESSION['email'])): ?>
        <p>Connecté en tant que : <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <a href="logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="connexion.php">Se connecter</a> | 
        <a href="inscription.php">Créer un compte</a>
    <?php endif; ?>
</body>
</html>
