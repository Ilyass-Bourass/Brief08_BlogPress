/*create database BlogPress; */

use BlogPress;

CREATE TABLE Auteur (
    Auteur_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) ,
    email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
    Date_creation_auteur TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table Article (
	Article_id INT AUTO_INCREMENT PRIMARY KEY,
    Auteur_id INT,
    titre varchar(100),
    Contenu TEXT,
    Date_creation_article TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foreign key ( Auteur_id ) references Auteur(Auteur_id )
);

create table Commentaire(
	commentaire_id INT AUTO_INCREMENT PRIMARY KEY,
    Article_id INT,
    nom_visiteur varchar(100),
	Date_creation_commentaire TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	foreign key ( Article_id) references Article(Article_id)
);

create table Statistiques (
	statistiques_id INT AUTO_INCREMENT PRIMARY KEY,
     Article_id INT,
     vues BIGINT,
     nombre_commentaire INT,
     nombre_jaime INT,
     foreign key ( Article_id) references Article(Article_id)
);




