<?php
$host = 'localhost';
$user = 'root';      // adapte si besoin
$pass = '';          // adapte si besoin

try {
    // Connexion sans base (pour créer la base)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création base
    $pdo->exec("CREATE DATABASE IF NOT EXISTS notes_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "Base 'notes_db' créée ou existante.<br>";

    // Connexion à la base créée
    $pdo->exec("USE notes_db");

    // Création tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS formations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            libelle VARCHAR(100) NOT NULL
        );
        
        CREATE TABLE IF NOT EXISTS matieres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(10) NOT NULL UNIQUE,
            libelle VARCHAR(100) NOT NULL,
            formation_id INT,
            FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE SET NULL
        );
        
        CREATE TABLE IF NOT EXISTS etudiants (
            id INT AUTO_INCREMENT PRIMARY KEY,
            matricule VARCHAR(20) NOT NULL UNIQUE,
            nom VARCHAR(50) NOT NULL,
            prenom VARCHAR(50) NOT NULL,
            adresse TEXT,
            tel VARCHAR(20),
            formation_id INT,
            FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE SET NULL
        );
        
        CREATE TABLE IF NOT EXISTS notes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            etudiant_id INT,
            matiere_id INT,
            note FLOAT,
            FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
            FOREIGN KEY (matiere_id) REFERENCES matieres(id) ON DELETE CASCADE
        );
    ");
    echo "Tables créées.<br>";

    // Insertion données exemple
    $pdo->exec("
        INSERT INTO formations (libelle) VALUES 
        ('Licence Informatique'),
        ('BTS Commerce');
        
        INSERT INTO matieres (code, libelle, formation_id) VALUES
        ('MATH101', 'Mathématiques', 1),
        ('INFO201', 'Programmation', 1),
        ('COM101', 'Communication', 2);
        
        INSERT INTO etudiants (matricule, nom, prenom, adresse, tel, formation_id) VALUES
        ('2025001', 'Diop', 'Aly', 'Dakar', '771234567', 1),
        ('2025002', 'Sarr', 'Fatou', 'Thiès', '776543210', 2);
    ");
    echo "Données d'exemple insérées.<br>";

    echo "Installation terminée avec succès.";

} catch (PDOException $e) {
    die("Erreur lors de l'installation : " . $e->getMessage());
}
