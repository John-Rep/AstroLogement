# Pour faire marcher ce projet en locale

### Entrez dans le dossier
```cd AstroLogement```

### Clone le projet

### Faites la commande : composer install

### Ajouter le fichier .env.dev avec le secret s'il y en a besoin
John Replogle possède le secret

### Relier une base de données
Créer le container docker :  
```docker run --name AstroLogement -p 3307:3306 -e MYSQL_DATABASE=AstroLogement -e MYSQL_ROOT_PASSWORD=SpaceBnB -d mysql```


Créer la base de données :  
```symfony console doctrine:database:create```


Installer les dépendances nécessaires :  
```composer require symfony/maker-bundle```  
```composer require symfony/twig-bundle```
```composer require symfony/asset```
