INSERT INTO conseil (texte,type_conseil) VALUES ("Bien libeller l’activité avec un verbe et un complément du verbe" , "BPMN" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Un acteur interne doit apparaître sous la forme d’un couloir au sein de la piscine
principale représentant le processus décrit dans l’organisation", "BPMN" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Un acteur externe fait l’objet d’une piscine à part. On ne connait pas l’organisation 
interne d’un autre SI, on ne sait que ce qu’on échange avec lui. C’est pourquoi, cette piscine ne contient que des évènements avec des flux de message et aucune activité.", "BPMN");

INSERT INTO conseil (texte,type_conseil) VALUES ("Un flux de message est la transmission en une seule fois , d'une information
structurée, entre un émetteur (qui en dispose) et un récepteur (qui en a besoin). Le message est l'information structurée que porte le flux." , "MCF");

INSERT INTO conseil (texte,type_conseil) VALUES ("Dans le MCF on  fait apparaitre uniquement les acteurs externes et les sous-domaines, mais pas les acteurs internes, car les 
acteurs internes font partie de la solution actuelle et sont indépendants du périmètre du SI.", "MCF" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Les sous-domaines sont des objectifs et sont libellés par un verbe à l’infinitif", "MCF" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Chaque entité doit posséder au moins un attribut identifiant, et l'ensemble
de ses attributs identifiants doivent être renseignés à la création de l'entité.", "MCD");

INSERT INTO conseil (texte,type_conseil) VALUES ("Les propriétés servant d'identifiant sont soulignées dans la
liste des propriétés ou précédées d'un dièse (#), pour les distinguer des autres propriétés.", "MCD");

INSERT INTO conseil (texte,type_conseil) VALUES ("Attention Si deux entités partagent la même propriété identifiante, alors il n'y a qu'une seule
entité et Si la même propriété peut être rattachée à des identifiants différents, c'est qu'il s'agit
en réalité de deux propriétés différentes, qu'il faut redéfinir", "MCD" );


INSERT INTO conseil (texte,type_conseil) VALUES ("Sur le BPMN, l’évènement doit pouvoir être retrouvé sur le BPMN . la transition également sous la forme
d’une activité." , "CVO" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Un cvo est un digramme qui compte un unique début et une ou plusieurs fin ", "CVO" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Un cvo comporte Des évènements internes ou externes. Les évènements externes sont des flux de message
apparaissant dans le MFC et le BPMN.
" , "CVO" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Un cvo comporte des transitions allant d’un évènement vers un état. Elle correspond au traitement qui va provoquer le
changement d’état de l’objet. les flèches allant d’un état vers un évènement indique simplement les
différents chemins possibles" , "CVO" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Sur l’axe horizontal, elle comporte le flot de narration suivant les
étapes du processus-métier (épics). Sur l’axe vertical, elle regroupe les besoins par objectifs, du plus
prioritaire au moins prioritaires" , "STORY_MAP");


INSERT INTO conseil (texte,type_conseil) VALUES ("une story map comporte un flot de narration qui permet de raconter l’histoire de l’utilisateur, qui va se servir du
produit ou de la fonctionnalité. L’enchainement des différentes activités se rapproche du processus-métier." , "STORY_MAP" );

INSERT INTO conseil (texte,type_conseil) VALUES ("Toutes les epics doivent se retrouver aussi sur le processus metier." , "STORY_MAP");