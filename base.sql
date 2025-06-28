-- Création de la base de données
CREATE DATABASE IF NOT EXISTS notes_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE notes_db;

-- Table formations
CREATE TABLE IF NOT EXISTS formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

-- Table matieres
CREATE TABLE IF NOT EXISTS matieres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    libelle VARCHAR(100) NOT NULL,
    formation_id INT,
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE SET NULL
);

-- Table etudiants
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

-- Table notes
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    matiere_id INT,
    note FLOAT,
    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    FOREIGN KEY (matiere_id) REFERENCES matieres(id) ON DELETE CASCADE
);

-- Données d'exemple pour formations
INSERT INTO formations (libelle) VALUES 
('Licence Informatique'),
('BTS Commerce');

-- Données d'exemple pour matières
INSERT INTO matieres (code, libelle, formation_id) VALUES
('MATH101', 'Mathématiques', 1),
('INFO201', 'Programmation', 1),
('COM101', 'Communication', 2);

-- Données d'exemple pour étudiants
INSERT INTO etudiants (matricule, nom, prenom, adresse, tel, formation_id) VALUES
('2025001', 'Diop', 'Aly', 'Dakar', '771234567', 1),
('2025002', 'Sarr', 'Fatou', 'Thiès', '776543210', 2);
