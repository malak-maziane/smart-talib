<?php
session_start();
require_once '../../config/db.php';

// Vérifier que l'utilisateur est un étudiant
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../login.php');
    exit();
}

// Récupérer les mots-clés et modules pour les filtres
$motsCles = $pdo->query("SELECT * FROM mots_cles")->fetchAll();
$modules = $pdo->query("SELECT * FROM modules")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Projets</title>
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
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="ajouter_projet.php">Soumettre Projet</a></li>
                    <li class="nav-item"><a class="nav-link" href="recherche_projets.php">Recherche</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../controllers/logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <h2>Recherche Avancée de Projets</h2>

    <form method="GET" action="recherche_projets.php">
        <input type="number" name="annee" placeholder="Année (ex: 2025)" value="<?= isset($_GET['annee']) ? $_GET['annee'] : '' ?>"><br><br>

        <select name="module_id">
            <option value="">-- Choisir un module --</option>
            <?php foreach ($modules as $module): ?>
                <option value="<?= $module['id'] ?>" <?= (isset($_GET['module_id']) && $_GET['module_id'] == $module['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($module['nom_module']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <select name="mot_cle_id">
            <option value="">-- Choisir un mot-clé --</option>
            <?php foreach ($motsCles as $mot): ?>
                <option value="<?= $mot['id'] ?>" <?= (isset($_GET['mot_cle_id']) && $_GET['mot_cle_id'] == $mot['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($mot['mot']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <select name="type">
            <option value="">-- Type de Projet --</option>
            <option value="stage" <?= (isset($_GET['type']) && $_GET['type'] == 'stage') ? 'selected' : '' ?>>Stage</option>
            <option value="module" <?= (isset($_GET['type']) && $_GET['type'] == 'module') ? 'selected' : '' ?>>Module</option>
        </select><br><br>

        <button type="submit">Chercher</button>
    </form>

    <hr>

    <h3>Résultats :</h3>

    <?php
    if (!empty($_GET)) {
        // Construction dynamique de la requête
        $sql = "SELECT DISTINCT p.*, e.prenom, e.nom FROM projets p 
                LEFT JOIN projet_module pm ON p.id = pm.projet_id 
                LEFT JOIN projet_mot_cle pmc ON p.id = pmc.projet_id 
                LEFT JOIN etudiant e ON p.etudiant_id = e.id
                WHERE 1=1 ";
        $params = [];

        if (!empty($_GET['annee'])) {
            $sql .= "AND p.date_soumission LIKE ? ";
            $params[] = $_GET['annee'] . '%';
        }

        if (!empty($_GET['module_id'])) {
            $sql .= "AND pm.module_id = ? ";
            $params[] = $_GET['module_id'];
        }

        if (!empty($_GET['mot_cle_id'])) {
            $sql .= "AND pmc.mot_cle_id = ? ";
            $params[] = $_GET['mot_cle_id'];
        }

        if (!empty($_GET['type'])) {
            $sql .= "AND p.type = ? ";
            $params[] = $_GET['type'];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $projets = $stmt->fetchAll();

        if ($projets) {
            echo "<ul>";
            foreach ($projets as $projet) {
              echo "<li>
              <strong>" . htmlspecialchars($projet['titre']) . "</strong> - " . htmlspecialchars($projet['type']) . " - État : " . htmlspecialchars($projet['etat']) . "<br>
              Soumis par : " . htmlspecialchars($projet['prenom']) . " " . htmlspecialchars($projet['nom']) . "<br>
              <form method='POST' action='../../controllers/like_projet.php'>
                  <input type='hidden' name='projet_id' value='" . $projet['id'] . "'>
                  <button type='submit' class='btn btn-outline-danger btn-sm'>❤️ Liker</button>
              </form>
          </li>";
  
            }
            echo "</ul>";
        } else {
            echo "Aucun projet trouvé.";
        }
    }
    ?>

    <br><a href="dashboard.php">Retour au Dashboard</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
