# TechnicalTest Sportyma
Test Technique Symfony4.4 


D'abord Modifier le username et le password et le nom de la base de données dans le ficheir .env 

Ensuite lancer cette commande pour créer la base de données :
# php bin/console doctrine:database:create

 lancer cette commande pour créer les entités et les mapping
# php bin/console doctrine:schema:update --force 


Puis lancer la fixture avec cette commande  commande : 
# php bin/console doctrine:fixtures:load


Finalement lancer l'application soit avec symfony CLI ou bien avec cette commande 
# php -S 127.0.0.1:8000 -t public 




