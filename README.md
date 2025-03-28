# 🌌 AstroLogement – Réservez votre séjour dans les étoiles

AstroLogement est une application web fictive de type **Airbnb galactique**, développée dans le cadre d’un hackathon intensif d’une semaine.  
Elle vous permet de réserver un logement spatial, de communiquer avec les hôtes et de gérer votre séjour… **aux confins de la galaxie.** 🛸

> Projet réalisé par une équipe de 4 développeurs dans le cadre de la formation CDA.

---

## ✨ Fonctionnalités principales

- 🔐 Authentification sécurisée (inscription / connexion)
- 📆 Réservation de logements sur différentes planètes
- 🪐 Affichage des logements disponibles (type Airbnb)
- 🛰️ **Messagerie en temps réel** avec rafraîchissement automatique
- 💬 Interface de conversation fluide, avatars, bulles, fond étoilé animé
- 📝 Formulaires de contact, avis, demandes de réservation
- 🌗 Interface responsive, animations & ambiance cosmique

---

## 🧪 Stack technique

- **Backend** : PHP 8 / Symfony
- **Frontend** : Twig + CSS custom 
- **Base de données** : MySQL (via AIVEN)
- **ORM** : Doctrine
- **Outils** : GitHub Project / Kanban / Figma / Platform.sh

---

## 🚀 Installation locale

### 1. Cloner le projet

# Pour faire marcher ce projet en locale

### Entrez dans le dossier
```cd AstroLogement```

### Clone le projet

### Faites la commande : composer install

### Relier une base de données
Créer le container docker :  
```docker run --name AstroLogement -p 3307:3306 -e MYSQL_DATABASE=AstroLogement -e MYSQL_ROOT_PASSWORD=SpaceBnB -d mysql```


Créer la base de données :  
```symfony console doctrine:database:create```


Installer les dépendances nécessaires :  
```composer require symfony/maker-bundle```  
```composer require symfony/twig-bundle```
```composer require symfony/asset```




Projet réalisé par :

🚀 John Replogle
🌌 Timothé Winkler
🧠 Mathis Truong
🛸 Yoann Le Chevalier
