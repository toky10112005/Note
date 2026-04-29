DROP DATABASE IF EXISTS Note;
CREATE DATABASE IF NOT EXISTS Note;
USE Note;



CREATE TABLE IF NOT EXISTS semestre(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    credits INT NOT NULL
);


CREATE TABLE IF NOT EXISTS matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_Semestre INT NOT NULL,
    matricule VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    coefficient INT NOT NULL,
    UNIQUE KEY uq_matiere_matricule (matricule),
    KEY idx_matiere_semestre (id_Semestre),
    FOREIGN KEY (id_Semestre) REFERENCES semestre(id)
);

CREATE TABLE IF NOT EXISTS parcour(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    responsable VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS parcour_matiere(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_parcour INT NOT NULL,
    matricule_matiere VARCHAR(255) NOT NULL,
    KEY idx_pm_parcour (id_parcour),
    KEY idx_pm_matiere (matricule_matiere),
    FOREIGN KEY (id_parcour) REFERENCES parcour(id),
    FOREIGN KEY (matricule_matiere) REFERENCES matiere(matricule)
);

CREATE TABLE IF NOT EXISTS groupe(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_parcour INT NOT NULL,
    numeros INT NOT NULL,
    matricule_matiere VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    KEY idx_groupe_parcour (id_parcour),
    KEY idx_groupe_matiere (matricule_matiere),
    FOREIGN KEY (id_parcour) REFERENCES parcour(id),
    FOREIGN KEY (matricule_matiere) REFERENCES matiere(matricule)
);

CREATE TABLE IF NOT EXISTS etudiant(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    matricule VARCHAR(255) NOT NULL,
    id_semestre INT NOT NULL,
    id_parcour INT DEFAULT NULL,
    KEY idx_etudiant_semestre (id_semestre),
    KEY idx_etudiant_parcour (id_parcour),
    FOREIGN KEY (id_semestre) REFERENCES semestre(id),
    FOREIGN KEY (id_parcour) REFERENCES parcour(id)
);

CREATE TABLE IF NOT EXISTS user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL
);

INSERT INTO semestre (nom, credits) VALUES ('S3', 30);
INSERT INTO semestre (nom, credits) VALUES ('S4', 30);

INSERT INTO matiere (id_Semestre, matricule, nom, coefficient) VALUES 
(1, 'INF201', 'Programmation orientée objet', 6),
(1, 'INF202', 'Base de données objets', 6),
(1, 'INF203', 'Programmation système', 4),
(1, 'INF208', 'Réseaux informatiques', 6),
(1, 'MTH201', 'Méthode numériques', 4),
(1, 'ORG201', 'Base de gestion', 4);

INSERT INTO matiere (id_Semestre, matricule, nom, coefficient) VALUES 
(2,'INF204','Système d information géographique',6),
(2,'INF205','Système d information',6),
(2,'INF206','Interface Homme Machine',6),
(2,'INF207','Element d algorithme',6),
(2,'INF209','Web dynamique',6),
(2,'INF210','Mini-projet de développement',10),
(2,'INF211','Mini Projet de base de données et ou réseaux',10),
(2,'INF212','Mini-projet de Web et Design',10),
(2,'MTH203','MAO',4),
(2,'MTH204','Geométrie',4),
(2,'MTH205','Equation différentielles',4),
(2,'MTH206','Optimisation',4),
(2,'MTH202','Analyse des Données',4);

INSERT INTO parcour(nom,responsable) VALUES
('Developpement','Razafinjoelina Tahina'),
('Base de Données','Rakotomalala Vahatraniaina'),
('Web et Design','Rabenanahary Rojo');

INSERT INTO parcour_matiere(id_parcour,matricule_matiere) VALUES
(1,'INF204'),
(1,'INF205'),
(1,'INF206'),
(1,'INF207'),
(1,'INF210'),
(1,'MTH204'),
(1,'MTH205'),
(1,'MTH206'),
(1,'MTH203'),
(2,'INF204'),
(2,'INF205'),
(2,'INF206'),
(2,'INF207'),
(2,'INF211'),
(2,'MTH205'),
(2,'MTH206'),
(2,'MTH203'),
(2,'MTH202'),
(3,'INF204'),
(3,'INF205'),
(3,'INF206'),
(3,'INF209'),
(3,'INF212'),
(3,'MTH202'),
(3,'MTH204'),
(3,'MTH206'),
(3,'MTH203');


INSERT INTO groupe(id_parcour, numeros, matricule_matiere, nom) VALUES 
(1, 1, 'INF204', 'Système d information géographique'),
(1, 1, 'INF205', 'Système d information'),
(1, 1, 'INF206', 'Interface Homme Machine'),
(1, 2, 'MTH204', 'Geométrie'),
(1, 2, 'MTH205', 'Equation différentielles'),
(1, 2,'MTH206', 'Optimisation'),
(2,1,'INF204','Système d information géographique'),
(2,1,'INF206','Interface Homme Machine'),
(2,1,'INF207','Element d algorithme'),
(2,2,'MTH202','Analyse des données'),
(2,2,'MTH205','Equation différentielles'),
(2,2,'MTH206','Optimisation'),
(3,1,'INF204','Système d information géographique'),
(3,1,'INF205','Système d information'),
(3,1,'INF206','Interface Homme Machine'),
(3,2,'MTH202','Analyse de données'),
(3,2,'MTH204','Géométrie'),
(3,2,'MTH206','Optimisation');

INSERT INTO etudiant(nom, prenom, matricule, id_semestre) VALUES
('Rasoa', 'Jean', '3909', 1),
('Rakoto', 'Marie', '3910', 1),
('Rabe', 'Andry', '3911', 2),
('Razanamparany', 'Lalao', '3912', 2),
('Ratsimbazafy', 'Hery', '3913', 2);
