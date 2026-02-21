<?php
session_start();
require_once '../config/db.php';

// Vérification de la session
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'encadrant') {
    header('Location: ../views/login.php');
    exit();
}

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Si le formulaire contient une remarque et une note
    if (isset($_POST['contenu']) && isset($_POST['note'])) {
        $contenu = htmlspecialchars(trim($_POST['contenu']));
        $note = (float) $_POST['note'];
        $projet_id = (int) $_POST['projet_id'];
        $encadrant_id = (int) $_SESSION['user']['id'];
        $date = date('Y-m-d');

        try {
            // Transaction pour insérer remarque + évaluation ensemble
            $pdo->beginTransaction();

            // Insertion remarque
            $stmt = $pdo->prepare("INSERT INTO remarques (contenu, date_remarque, projet_id, encadrant_id, created_at) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$contenu, $date, $projet_id, $encadrant_id]);

            // Insertion évaluation
            $stmt = $pdo->prepare("INSERT INTO evaluations (note, commentaire, date_evaluation, projet_id, encadrant_id, created_at) 
                                   VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$note, $contenu, $date, $projet_id, $encadrant_id]);

            $pdo->commit();
            
            header('Location: ../views/encadrant/dashboard.php?success=remarque');
            exit();

        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Erreur lors de l'ajout : " . $e->getMessage();
            exit();
        }
    }
    
    // Sinon, si c'est une action de validation/refus
    elseif (isset($_POST['action']) && isset($_POST['projet_id'])) {
        $action = $_POST['action'];
        $projet_id = (int) $_POST['projet_id'];
        $encadrant_id = (int) $_SESSION['user']['id'];

        if ($action == 'valider') {
            $etat = 'valide';
        } elseif ($action == 'refuser') {
            $etat = 'refuse';
        } else {
            header('Location: ../views/encadrant/dashboard.php?error=action');
            exit();
        }

        $stmt = $pdo->prepare("UPDATE projets SET etat = ?, encadrant_id = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$etat, $encadrant_id, $projet_id]);

        header('Location: ../views/encadrant/dashboard.php?success=etat');
        exit();
    }
    
    // Si rien de valide n'est envoyé
    else {
        header('Location: ../views/encadrant/dashboard.php?error=invalide');
        exit();
    }
}
?>
