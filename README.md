1.Clonez le projet depuis Github

HTTPS : git: https://github.com/BlackWolker/DevSecur.git

2.Créer le .env

APP_ENV=dev
APP_SECRET=rzeyuiryzeuryezuiyr
DATABASE_URL='sqlsrv://sa:sql2022@localhost/DevSecur'
3.Installez les dépendances

composer install 
4.Créer la base de donnée avec le script SQL script.sql présent à la racine du projet

ou si vous avez sql server:
 symfony console doctrine:database:create

5.Lancer cette commande qui démarra le serveur

symfony server:start
