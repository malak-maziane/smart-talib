<?php
session_start();
require_once('C:/xampp/htdocs/projets_ensak/config/db.php');

// Vérifiez si l'utilisateur est connecté et est un étudiant
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../login.php');
    exit();
}

$etudiant_id = $_SESSION['user']['id'];

// Récupérer les projets de l'étudiant
$stmt = $pdo->prepare("SELECT * FROM projets WHERE etudiant_id = ?");
$stmt->execute([$etudiant_id]);
$projets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Projets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestion Projets ENSAK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'etudiant') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ajouter_projet.php">Soumettre Projet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="recherche_projets.php">Recherche</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/projets_ensak/controllers/logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Mes Projets</h2>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Retour au dashboard</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Type</th>
                    <th>Date de Soumission</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $projet) : ?>
                    <tr>
                        <td><?= htmlspecialchars($projet['titre']) ?></td>
                        <td><?= htmlspecialchars($projet['description']) ?></td>
                        <td><?= htmlspecialchars($projet['categorie']) ?></td>
                        <td><?= htmlspecialchars($projet['type']) ?></td>
                        <td><?= htmlspecialchars($projet['date_soumission']) ?></td>
                        <td><?= htmlspecialchars($projet['etat']) ?></td>
                        <td>
                            <!-- Générer certificat -->
                            <?php if ($projet['etat'] === 'valide') : ?>
                                <a class="btn btn-success btn-sm" href="/projets_ensak/controllers/generer_certificat.php?projet_id=<?= $projet['id'] ?>">
                                    📄 Générer Certificat
                                </a>
                            <?php else : ?>
                                <span class="text-warning">En attente validation</span>
                            <?php endif; ?>

                            <!-- Liker un projet -->
                            <form method="POST" action="/projets_ensak/controllers/like_projet.php" class="d-inline-block mt-2">
                                <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm">❤️ Liker</button>
                            </form>

                            <?php
                            // Compter le nombre de likes
                            $stmtLikes = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE projet_id = ?");
                            $stmtLikes->execute([$projet['id']]);
                            $likesCount = $stmtLikes->fetchColumn();
                            ?>
                            <p class="mb-0"><?= $likesCount ?> like(s)</p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
