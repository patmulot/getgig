# getgig (Single Page Application)
site de booking / mise en relation entre des artistes ou des organisateur d'évènement via un système d'annonce et de messagerie.

***description détaillée du projet plus bas...***

quelques images :
---
![getgig-img1](https://github.com/patmulot/getgig/blob/main/getgig-img1.JPG)
---
![getgig-img2](https://github.com/patmulot/getgig/blob/main/getgig-img2.JPG)
---
![getgig-img2](https://github.com/patmulot/getgig/blob/main/getgig-img3.JPG)


# DESCRIPTION DETAILLEE 

***avant propos :***
*C'est un projet de fin de formation (formation développeur web fullstack PHP + spécialisation Wordpress au près de l'organisme de formation O'clock) sur lequel nous avons travaillé en équipe de 4 Développeurs spé Wordpress. L'objectif principale de ce projet était de pratiquer la mise en situation professionnelle en respectant un protocole de gestion, un projet attribué, des roles attribués, un delai et un MVP livrable. Nous avons 4 semaines pour développer ce projet dont seulement 3 semaines de code puisque le sprint0 était entièrement consacré à la mise en place des documents préliminaires ***(cahier des charges, trello, wireframes, documents relatifs à la BDD, MCD, plan de site, etc..)***.*

*Nous avons travaillé en utilisant des repo github avec un protocole stricte. Nous avons 2 repos, un pour le back et un pour le front. Chacun de ces repos possède une version fonctionnelle "livrable" sur le master, et une branche "develop" sur laquel nous travaillons et connectons/mergons chacunes de nos branches respectives lorsque nous estimons nos nouvelles fonctionnalités comme terminée. Apres quoi, nous provoquions de nouvelles réunions tous ensemble afin de tester, merger, puis re-tester les nouvelles fonctionnalités de la branche develop et si tout était OK nous la mergions sur le master puis mettions à jour les 2 servers.*

*Nous avons développé ce projet sur 2 servers distants AWS, un pour le back où se trouve l'installation de wordpress et de nos plugins customs/cpt et autre, et un autre où se trouve le projet front et le build de tout le code vuejs, le tout déployé sur surge pour le moment.*

*En plus de nos roles respectifs de developpeurs back et front, nous nous sommes attribués les roles de Scrum Master, Git Master, et Product Owner (moi même) pour nous répartir efficacement les tâches associées à ce projet et pour respecter au mieux la mise en situation professionnelle de ce projet. (à noter qu'en pratique, nous passions régulièrement de l'un à l'autre puis que nous avons tous les 4 pratiqué les 2 côtés tout au long de la formation et de la spécialisation)*

## Back
Côté back nous avons donc une installation de wordpress dans laquelle se trouve :
- notre plugin custom "getgigback" avec lequel nous ajoutons toutes nos nouvelles fonctionnalités custom à notre projet Wordpress vide
- notre principal Custom Post Type (CPT) pour les annonces, il comporte plusieurs post_meta de wordpress qui permettent de renseigner des informations non disponibles autrement (les dates de début et fin d'évènement, les lieux, etc..),
- une Custom Taxonomy (pour les types d'annonce Organisateur ou Artiste)
- la déclaration/instanciation de notre nouvelle table custom pour la messagerie (Nous avions besoin d'un nouveau modèle de table qui n'existe pas nativement dans Wordpress pour gérer les fonctionnalités de messagerie comme le contenu des messages associés aux id des destinataires et expéditeurs des messages) Cette table est automatiquement crée à l'activation du plugin que nous avons créé.
- la déclaration de tous nos custom Endpoints pour délivrer nos nouvelles routes de l'API (CRUD pour les annonces/utilisateurs/messages)
- et l'utilisation de la Geo API (publique) pour la gestion des localité des utilisateurs et des évènements.
- les plugins ACF (pour nos metas) et JWT (pour la gestion des tokens)

## Front
côté front, dans une volonté de produire un site en "Single Page Application", nous avons utilisé vuejs :
- tous les composants contenant les vues ainsi que leurs enfants (composant "home" qui contient des composants "about" ou "thumbnail")
- le router vuejs pour les changements de page sans rafraichissement du navigateur
- les services (tous les services permettant de se connecter et commmuniquer en post/get/etc.. avec les routes API custom ou non de notre Back par exemple "userService" pour la gestion des routes et des data utilisateurs
- tous les mécanismes dynamiques d'interaction sur le dom pour le comfort de navigation tout comme pour la récupération/affichage dynamique des données
- tous les formulaires qui instruisent la base de donnée tant pour la création/modification d'utilisateurs ou profils utilisateurs que pour les annonces.
- les fichiers SASS avec toutes les variables/mixins afin de pouvoir agir une seule fois sur tous les éléments du dom en cas de modification/mise à jour du style du site
- le responsive de toutes les pages car le site est en mobile first (class bootstrap/composants bootstrap/javascript pour la gestion du responsive)
