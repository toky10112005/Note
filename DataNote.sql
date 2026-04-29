CREATE DATABASE IF NOT EXISTS Note;
USE Note;

--S3-S4..

CREATE TABLE IF NOT EXISTS semestre(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    credits INT NOT NULL--total crédits
);



CREATE TABLE IF NOT EXISTS matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_Semestre INT NOT NULL,
    matricule VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    coefficient INT NOT NULL,
    FOREIGN KEY (id_Semestre) REFERENCES semestre(id)
);

CREATE TABLE IF NOT EXISTS parcour(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    responsable VARCHAR(255) NOT NULL,
);

CREATE TABLE IF NOT EXISTS parcour_matiere(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_parcour INT NOT NULL,
    matricule_matiere VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_parcour) REFERENCES parcour(id),
    FOREIGN KEY (matricule_matiere) REFERENCES matiere(matricule)
);

CREATE TABLE IF NOT EXISTS groupe(--Eto ilay groupe de matiere safidina
    id INT AUTO_INCREMENT PRIMARY KEY,
    numeros INT NOT NULL,
    matricule_matiere VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    FOREIGN KEY (matricule_matiere) REFERENCES matiere(matricule)
);

INSERT INTO semestre (nom, credits) VALUES ('S3', 30);
INSERT INTO semestre (nom, credits) VALUES ('S4', 30);

INSERT INTO matiere (id_Semestre, matricule, nom, coefficient) VALUES 
(1, 'INF201', 'Programmation orientée objet', 6),
(1, 'INF202', 'Base de données objets', 6),
(1, 'INF203', 'Programmation système', 4),
(1, 'INF208', 'Réseaux informatiques', 6),
(1, 'MTH201', 'Méthode numériques', 4),
(1, 'ORG201', 'Base de gestion', 4),


INSERT INTO matiere (id_Semestre, matricule, nom, coefficient) VALUES 
(2,'INF204','Système d information géographique',6),
(2,'INF205','Système d information',6),
(2,'INF206','Interface Homme Machine',6),
(2,'INF207','Element d algorithme',6),
(2,'INF210','Mini-projet de développement',10),
(2,'MTH204','Geométrie',4),
(2,'MTH205','Equation différentielles',4),
(2,'MTH206','Optimisation',4),
(2,'MTH203','MAO',4);

INSERT INTO parcour(nom,responsable) VALUES
('Developpement','Razafinjoelina Tahina'),
('Base de Données','Rakotomalala Vahatraniaina'),
('Web et Design','Rabenanahary Rojo');

INSERT INTO parcour_matiere(id_parcour,matricule_matiere) VALUES
(1,'INF204'),
(1,'INF204'),

INSERT INTO groupe(numeros, matricule_matiere, nom) VALUES 
(1, 'INF204', 'Système d information géographique'),
(1, 'INF205', 'Système d information'),
(1, 'INF206', 'Interface Homme Machine'),
(2, 'MTH204', 'Geométrie'),
(2, 'MTH205', 'Equation différentielles'),
(2, 'MTH206', 'Optimisation');


