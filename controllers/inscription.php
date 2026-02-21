<?php require_once '../controllers/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - ENSA Gestion Projets</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1 class="logo">Créer un Compte - <span>ENSA</span></h1>
            <nav class="site-nav">
                <ul>
                    <li><a href="index.php" class="nav-link">Accueil</a></li>
                    <li><a href="login.php" class="nav-link">Connexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <section class="form-section">
            <div class="container">
                <h2 class="form-title">Créer votre compte</h2>
                <form action="/projets_ensak/views/backend/register.php" method="POST" class="form-card">
    <input type="text" name="prenom" placeholder="Nom d'utilisateur" required>
    <input type="email" name="email" placeholder="Adresse Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="password" name="confirm_password" placeholder="Confirmer mot de passe" required>

    <!-- Choisir le type de compte -->
    <select name="role" required>
        <option value="">-- Sélectionnez votre rôle --</option>
        <option value="etudiant">Étudiant</option>
        <option value="encadrant">Encadrant</option>
        <option value="admin">Administrateur</option>
    </select>
    <button type="submit" class="btn-primary">S'inscrire</button>
</form>

            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; 2025 ENSA Kénitra - Technologies Web.</p>
        </div>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>
