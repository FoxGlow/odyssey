CREATE TABLE utilisateur(
id_utilisateur int PRIMARY KEY NOT NULL AUTO_INCREMENT,
nom VARCHAR (255), 
prenom VARCHAR (255), 
mail VARCHAR (255),
mot_de_passe VARCHAR(255) NOT NULL,
UNIQUE KEY unique_email (mail));


CREATE TABLE projet(
id_projet int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
nom VARCHAR (255) NOT NULL, 
description VARCHAR(255) NOT NULL,
ref_chef int NOT NULL,
CONSTRAINT FK_PROJET_REF_CHEF FOREIGN KEY (ref_chef) REFERENCES utilisateur(id_utilisateur));


CREATE TABLE message(
id_message INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
texte VARCHAR (1024) NOT NULL,
date_ DATETIME NOT NULL,
ref_utilisateur INT NOT NULL,
ref_projet INT NOT NULL,
CONSTRAINT FK_REF_UTILISATEUR FOREIGN KEY (ref_utilisateur) REFERENCES utilisateur(id_utilisateur),  
CONSTRAINT FK_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE associe(
    ref_utilisateur int NOT NULL AUTO_INCREMENT,
    ref_projet int NOT NULL,
    CONSTRAINT PK_ASSOCIE PRIMARY KEY (ref_utilisateur , ref_projet),
    CONSTRAINT FK_ASSOCIE_REF_UTILISATEUR FOREIGN KEY (ref_utilisateur)
        REFERENCES utilisateur (id_utilisateur),
    CONSTRAINT FK_ASSOCIE_REF_PROJET FOREIGN KEY (ref_projet)
        REFERENCES projet (id_projet)
    ON DELETE CASCADE
);

CREATE TABLE feedback(
id_feedback int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
message VARCHAR (1024) NOT NULL, 
ref_projet int NOT NULL,
CONSTRAINT FK_FEEDBACK_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE mcd( 
id_mcd int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long NOT NULL,
ref_projet int NOT NULL,
CONSTRAINT FK_MCD_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE cvo( 
id_cvo int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long NOT NULL,
ref_projet int NOT NULL,
CONSTRAINT FK_CVO_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE bpmn( 
id_bpmn int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long NOT NULL,
ref_projet int NOT NULL,
CONSTRAINT FK_BPMN_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE story_map( 
id_story_map int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long NOT NULL,
ref_projet int NOT NULL,
CONSTRAINT FK_STORY_MAP_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE mcf( 
id_mcf int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long NOT NULL,
ref_projet int NOT NULL,
CONSTRAINT FK_MCF_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE conseil (
id_conseil int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
texte VARCHAR (556) NOT NULL, 
type VARCHAR (255) NOT NULL);