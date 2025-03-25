# Pour faire marcher ce projet en locale

### Clone le projet

### Faites la commande : composer install

### Ajouter le fichier .env.dev avec le secret s'il y en a besoin
John Replogle possède le secret

### Relier une base de données
Créer le container docker :


```docker run --name AstroLogement -p 3307:3306 -e MYSQL_DATABASE=AstroLogement -e MYSQL_ROOT_PASSWORD=SpaceBnB -d mysql```


Créer la base de données : 


```symfony console doctrine:database:create```
