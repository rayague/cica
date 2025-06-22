@echo off
echo Démarrage de l'application Laravel...

rem Aller dans le répertoire du projet Laravel
cd /d C:\Users\hp\Documents\cica

rem Exécuter les commandes nécessaires
call npm install   rem Installer les dépendances NPM
call npm run dev    rem Démarrer Vite (ou npm run build si c'est pour la production)

rem Démarrer le serveur Laravel
call php artisan migrate --seed   rem Appliquer les migrations et les seeders
call php artisan serve   rem Lancer le serveur Laravel

rem Lancer la commande de build si nécessaire
rem call npm run build

echo Application Laravel démarrée avec succès !
pause
