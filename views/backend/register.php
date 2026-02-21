<?php
session_start();

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=projets_ensak", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification de la présence des champs
    if (isset($_POST['prenom'], $_POST['email'], $_POST['mot_de_passe'])) {
        // Récupérer les données du formulaire
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Hacher le mot de passe avant de l'insérer
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Vérifier si l'utilisateur existe déjà
        $query = "SELECT COUNT(*) FROM utilisateurs WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $user_exists = $stmt->fetchColumn();

        if ($user_exists > 0) {
            $_SESSION['error'] = "Cet email est déjà utilisé.";
        } else {
            // Préparer la requête SQL d'insertion
            $query = "INSERT INTO utilisateurs (prenom, email, mot_de_passe) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);

            // Exécuter la requête avec les données liées
            if ($stmt->execute([$prenom, $email, $hashed_password])) {
                $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                header('Location: ../login.php'); // Rediriger vers la page de connexion
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'inscription. Essayez à nouveau.";
            }
        }
    } else {
        $_SESSION['error'] = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Gestion Projets ENSAK</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="site-header">
    <div class="container">
        <nav class="site-nav">
            <ul>
                <!-- Lien vers la page d'accueil -->
                <li><a href="../index.php" class="nav-link">Accueil</a></li>
                
                <!-- Lien vers la page de connexion -->
                <li><a href="../login.php" class="nav-link">Connexion</a></li>
                
                <!-- Lien vers la page d'inscription -->
                <li><a href="../inscription.php" class="nav-link">Inscription</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <h2>Inscription</h2>

    <!-- Afficher les messages d'erreur ou succès -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'inscription -->
    <form method="POST" action="register.php">
        <div class="mb-3">
            <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
        </div>

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <input type="password" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
