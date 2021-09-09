# PROCES DURE D'UN STALLE A SION

## 1 - se placer dans public

## 2 - executer la commande ```composer update``` (ou ```composer install``` si c'est la première installation)

## 3 - corriger le fichier wp-config. (url)

## 4 - créer le dossier image :
    - dans le repertoire "content"
    - créer le dossier "uploads" (/public/content/uploads),
    - y créer le dossier de l'année en cours ud projet exemple : "2021" (/public/content/uploads/2021),
    - y créer le dossier du mois en cours du projet exemple : "08" pour aout (/public/content/uploads/2021/08),
    - pour tous les repertoires depuis uploads, donner les droits a WP avec la commande ```chmod 777 nomDuDossier```