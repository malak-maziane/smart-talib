<?php
session_start();
require_once '../config/db.php'; // Assurez-vous que db.php est correct et fonctionne bien

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des entrées
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role']; // étudiant / encadrant / admin

    // Vérifier si l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'email est invalide.";
        header("Location: login.php");
        exit();
    }

    // Vérifier si le rôle est valide
    if (!in_array($role, ['etudiant', 'encadrant', 'admin'])) {
        $_SESSION['error'] = "Rôle non valide.";
        header("Location: login.php");
        exit();
    }

    // Préparer la requête en fonction du rôle
    if ($role == 'etudiant') {
        $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE email = ?");
    } elseif ($role == 'encadrant') {
        $stmt = $pdo->prepare("SELECT * FROM encadrant WHERE email = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    }

    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Si le mot de passe est correct
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $role;

        // Rediriger vers le dashboard en fonction du rôle
        header("Location: ../views/{$role}/dashboard.php");
        exit();
    } else {
        // Erreur si les informations sont incorrectes
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header("Location: login.php");
        exit();
    }
}
