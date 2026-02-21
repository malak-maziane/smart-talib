<?php
session_start();
require_once '../config/db.php';

// Vérification que l'utilisateur est connecté et encadrant
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'encadrant') {
    header('Location: ../views/login.php');
    exit();
}

// Traitement du formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécuriser les données reçues
    $contenu = htmlspecialchars(trim($_POST['contenu']));
    $note = (float) $_POST['note']; // conversion directe pour éviter les injections
    $projet_id = (int) $_POST['projet_id'];
    $encadrant_id = (int) $_SESSION['user']['id'];
    $date = date('Y-m-d');

    if ($contenu && $note >= 0 && $note <= 20) {
        try {
            // Début transaction
            $pdo->beginTransaction();

            // Insertion remarque
            $stmt = $pdo->prepare("INSERT INTO remarques (contenu, date_remarque, projet_id, encadrant_id, created_at) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$contenu, $date, $projet_id, $encadrant_id]);

            // Insertion évaluation
            $stmt = $pdo->prepare("INSERT INTO evaluations (note, commentaire, date_evaluation, projet_id, encadrant_id, created_at) 
                                   VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$note, $contenu, $date, $projet_id, $encadrant_id]);

            // Commit transaction
            $pdo->commit();

            // Redirection avec message succès
            header('Location: ../views/encadrant/dashboard.php?success=1');
            exit();

        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Erreur lors de l'ajout : " . $e->getMessage();
            exit();
        }
    } else {
        // Redirection en cas d'erreur de saisie
        header('Location: ../views/encadrant/dashboard.php?error=1');
        exit();
    }
}
?>
