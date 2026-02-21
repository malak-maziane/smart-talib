<?php
ob_start(); // important : tampon de sortie
session_start();

require_once('../config/db.php');
require_once('../libs/fpdf/fpdf.php');

// Vérifie que l'utilisateur est bien connecté et est un étudiant
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../views/login.php');
    exit();
}

// Vérifie que l'ID du projet est passé
if (!isset($_GET['projet_id'])) {
    exit('Projet non spécifié.');
}

$projet_id = $_GET['projet_id'];
$etudiant_id = $_SESSION['user']['id'];

// Vérifie si le projet est valide et appartient à l'étudiant
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ? AND etudiant_id = ? AND etat = 'valide'");
$stmt->execute([$projet_id, $etudiant_id]);
$projet = $stmt->fetch();

if (!$projet) {
    exit("Projet introuvable ou non validé.");
}

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'CERTIFICAT DE PROJET', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$texte = "Ce certificat atteste que l'étudiant(e) " . $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom'] . 
         " a réalisé le projet intitulé : \"" . $projet['titre'] . "\" dans la catégorie : " . $projet['categorie'] . 
         " durant l'année académique.";
$pdf->MultiCell(0, 10, utf8_decode($texte), 0, 'L');

// Date et signature
$pdf->Ln(20);
$pdf->Cell(0, 10, utf8_decode('Date : ' . date('d/m/Y')), 0, 1, 'R');
$pdf->Ln(10);
$pdf->Cell(0, 10, utf8_decode('Signature Responsable de Filière'), 0, 1, 'R');

// Sauvegarde sur le serveur
$chemin_certificat = "../certificats/certificat_projet_" . $projet_id . ".pdf";
$pdf->Output('F', $chemin_certificat);

// Enregistre le certificat dans la BDD
$stmt = $pdo->prepare("INSERT INTO certificats (projet_id, date_generation, chemin_fichier, statut, created_at) 
                       VALUES (?, ?, ?, 'genere', NOW())
                       ON DUPLICATE KEY UPDATE statut = 'genere', updated_at = NOW()");
$stmt->execute([$projet_id, date('Y-m-d'), $chemin_certificat]);

// Supprime toute sortie précédente
ob_end_clean();

// Envoie le fichier au navigateur
$pdf->Output('D', 'certificat_projet_' . $projet_id . '.pdf');
exit();
