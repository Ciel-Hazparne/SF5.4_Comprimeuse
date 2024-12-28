# Présentation générale du système supportant le projet

La société **Eiffage** a été missionnée pour la remise à niveau de la machine « Comprimeuse » dans le cadre de la réforme du bac professionnel MSPC.  
Le but de ce rétrofit était d’apporter les modifications suivantes :  
- Mise en place d’un automate industriel disposant d’une communication Ethernet (Profinet).  
- Installation d’un système de supervision industrielle.  
- Mise en place d’un bus de terrain pour E/S déportée.  
- Implantation d’un robot collaboratif sur réseau Ethernet.  

Une IHM sur le poste de supervision permet de lancer la production, mais un suivi de la production est à implémenter et sera réalisé par deux étudiants du BTS SN IR. Il faudra aussi prévoir une interface de test afin de préparer le système avant de le mettre en production.  

Ce suivi de production pourra se faire selon deux modes :  
- **En local**, en intégrant dans le logiciel Kscada SIView les fonctionnalités :  
  - Recherche historique production par ordre de fabrication (OF).  
  - Suppression historique production pour un OF.  
  - Test production.  
- **À distance**, depuis une IHM évolutive permettant un suivi de production avec des fonctionnalités supplémentaires.  

---

## 2. IHM locale

### 2.1 Interface « Recherche Historique de Production »

Cette interface doit permettre de visualiser l’historique d’un OF (Ordre de Fabrication) en lisant les données envoyées par l’automate dans une base de données **MS SQL Server 2019** :  

- Fabricant.  
- Type de production.  
- Horodatage début et fin de production.  
- Nombre de flacons.  
- Nombre de bouchons.  
- Nombre de prises robot.  
- Nombre de dépôts robot.  

---

### 2.2 Interface « Suppression Historique de Production »

Cette interface doit permettre de supprimer l’historique d’un OF (Ordre de Fabrication) s’il existe (recherche préalable).  

---

### 2.3 Interface « Test de Production » *(optionnelle)*

Cette interface doit permettre de tester l’application et de la valider avant mise en production, sans avoir le robot connecté ni être dans l’atelier maintenance.  
Il suffira de connecter l’automate au même réseau que le PC de supervision pour écrire les données énoncées précédemment (section 2.1) dans l’automate. Ces données seront ensuite insérées dans la base de données.  

---

## 3. IHM distante

L’IHM distante sera une **application web** permettant d’afficher les mêmes informations que l’IHM locale, mais avec des fonctionnalités supplémentaires :  
- Gestion des utilisateurs.  
- Histogrammes de production.  
- Alarmes *(optionnel)*.  
