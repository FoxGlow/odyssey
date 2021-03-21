# Odyssey

## Présentation

Cette application permet aux étudiants, professeurs et business analysts de stocker 
leurs projet pouvant être couplé avec un système de collaboration, ainsi que de contrôler la 
cohérence de leurs axes d'analyse et de détecter les carences, afin d'avoir une analyse 
complète et intègre.    

**Odyssey** est une application open source distribuée sous licence MIT.

[![forthebadge](http://forthebadge.com/images/badges/built-with-love.svg)](http://forthebadge.com)

___

## Mettre en place Odyssey (en local)

> Ce projet à été conçu avec les versions PHP>=8.0 ainsi que MySQL>=8.0.0 . 
> Il est recommandé d'utiliser la même configuration pour éviter tout problème.
> Vous aurez également besoin de l'outil Composer pour télécharger les dépendances.

0. Clonez le dépot sur votre machine
1. Renommez le fichier **.env.example** en **.env**
2. Remplissez les différents champs de configuration du fichier **.env**
3. Via le terminal, placez-vous dans le dossier du dépôt puis effectuez la commande 
`$ composer install`
4. Lancez le serveur MySQL, puis créez une base de données vide.
5. Éxecutez le script SQL contenu dans le fichier **database/tables.sql**
6. Éxecutez ensuite le script SQL contenu dans le fichier **database/advices.sql**
7. Lancez un serveur de développement PHP via le terminal dans le dossier du dépôt 
comme ceci : `$ php -S localhost:8000 -t public`
8. Rendez-vous sur **localhost:8000** depuis votre navigateur
9. Expérimentez ! 🚀

___

## Fonctionnalités principales

* Stocker les fichiers importés correspondant aux axes d'analyse
* Permettre la collaboration entre les utilisateurs
* Calculer différents taux de couverture (actuellement MCF/BPMN & Story-map/BPMN)
* Croiser les épics d'une story-map avec les activités du BPMN
* Croiser les flux du MCF avec ceux du BPMN
* Fournir des conseils

___

## Auteurs

* Hugolin MARIETTE
* Simon BOUTROUILLE
* Abdelnor AIT ALI
* Amaury DENIS
* Zineb BRAHIMI
* Kamelia BRAHIMI
* Yuxuan SUN
* Thileli SACI
