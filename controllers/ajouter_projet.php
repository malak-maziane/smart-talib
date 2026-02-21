<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Gestion Projets ENSAK</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <!-- Pour les étudiants -->
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

        <!-- Pour les encadrants -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'encadrant') : ?>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard Encadrant</a>
          </li>
        <?php endif; ?>

        <!-- Pour les admins -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard Admin</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="../../projets_ensak/controllers/logout.php">Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php
session_start();
require_once '../../projets_ensak/config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../controllers/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $type = $_POST['type'];
    $date_soumission = date('Y-m-d');
    $etudiant_id = $_SESSION['user']['id'];

    // Insertion projet
    $stmt = $pdo->prepare("INSERT INTO projets (titre, description, categorie, type, date_soumission, etudiant_id, created_at) 
                           VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$titre, $description, $categorie, $type, $date_soumission, $etudiant_id]);

    $projet_id = $pdo->lastInsertId();

    // Gestion du livrable uploadé
    if (isset($_FILES['livrable']) && $_FILES['livrable']['error'] === 0) {
        $allowed_types = ['application/pdf', 'application/zip'];
        if (in_array($_FILES['livrable']['type'], $allowed_types)) {
            $file_name = basename($_FILES['livrable']['name']);
            $target_dir = "../uploads/";
            $target_file = $target_dir . uniqid() . "_" . $file_name;
            move_uploaded_file($_FILES['livrable']['tmp_name'], $target_file);

            // Insertion du livrable
            $stmt = $pdo->prepare("INSERT INTO livrables (nom_fichier, type, chemin_fichier, projet_id, created_at) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$file_name, $_FILES['livrable']['type'], $target_file, $projet_id]);
        }
    }

    header("Location:/projets_ensak/views/etudiant/mes_projets.php");
    exit();
}
?>
