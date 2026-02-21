<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role']; // étudiant / encadrant / admin

    if ($role == 'etudiant') {
        $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE email = ?");
    } elseif ($role == 'encadrant') {
        $stmt = $pdo->prepare("SELECT * FROM encadrant WHERE email = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    }

    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user'] = $user;
        $_SESSION['role'] = $role;
        header("Location: ../views/" .$role ."/dashboard.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>
