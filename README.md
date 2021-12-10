# ocsProjet7_Api-bilemo

----------------------infos doc--------------------

versions symfony : https://symfony.com/releases
bundles symfony :
    https://packagist.org/
    https://flex.symfony.com/

----------------------infos commande--------------------

penser a executer wampserver pour acceder a la base de donnee via phpmyadmin

commande pour excuter le serveur web de symfony :
    symfony server:start
    Dans son navigateur aller a l adresse : http://127.0.0.1:8000

commande pour excuter les fixtures :
    cette commande vide totalement la base de données avant d'insérer les nouvelles données:
        php bin/console doctrine:fixtures:load

dans le fichier "composer.json" un script (que j ai nommé « reset-data ») a été crée pour remettre a zero ma base de donnée, surtout utile pour l'utilisation d'un jeu de donnée via des fixtures. Pour l executer il suffit d'executer la commande suivante :
            
            composer reset-data
    
    apres il faudra creer un dossier "migrations" a la racine du projet si il n'existe pas
    puis lancer les commandes suivantes :
        php bin/console doctrine:migrations:generate
        php bin/console make:migration
        php bin/console doctrine:migrations:migrate

----------------------infos project--------------------

30/11/2021 : creation of the project symfony5.4

30/11/2021 : creation entity Compagny, Product and migration - migrate

01/12/2021 : Creation of fixtures ("CompagnyFixtures" and "ProductFixtures"), of the ApiController controller (for test api via postman)

01/12/2021 : create the dev2 branch to test jwt

03/12/2021 : integration of jwt and test authentication with token 

05/12/2021 : integration of the "Customer" entity and its fixture

05/12/2021 : integration of group 1/2 and also in apiController the functions listCutomer / showCustomer 

05/12/2021 : creation of functions createCustomer, deleteCustomer

07/12/2021 : Modify function deleteCustomer, showCustomer (verification that the customer belongs to the company to access the resource), listCustomer (to display only the list of customers of the company)

10/12/2021 : Customer entity modification to add the email property + modification of the fixture accordingly. Modification of the "createCustomer" function not to create the same customer twice

10/12/2021 : Modification of listProduct to manage pagination and also modify the route of showProduct

10/12/2021 : Modification after problem github