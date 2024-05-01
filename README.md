# trottoirslibres
Outil disponible sur le web pour désigner une incivilité sur les trottoirs. Création d'un mail, envoi aux services communaux concernés.
## Description de la demande :
Création d’une application web mise à disposition des piétons bruxellois. Cette application permettra aux piétons rencontrant un obstacle à leur circulation sur un trottoir bruxellois de signaler l’obstacle aux services de la commune concernée à savoir l’échevin de la mobilité.
Application web public alimentée par un back office créé en PHP.
Formulaire de signalisation d’une anomalie sur le réseau piéton comprenant les champs à remplir suivant :
- Adresse de l’anomalie(ce champs pourrait-être rempli de 2 façons différentes au choix, 
une géo localisation reprenant les coordonnées du téléphone du piéton
 ou un formulaire comprenant plusieurs champs à savoir,  le nom de la voie, le numéro dans cette voie, le code postal, et le nom de la commune(une auto complétion pour chaque champs, donnera des propositions cliquables à l’internaute afin de faciliter la saisie de celle-ci).
- Le type d’encombrement, sous forme de liste déroulante le piéton encombré sélectionnerait dans cette liste le type d’encombrement subi, une option lui permettrait de créer un nouveau type d’encombrement si sa situation n’était pas déjà listée.
- Les coordonnées du piéton, nom prénom, mail. Une clause accompagnée d’une case à cocher demandera à l’internaute son autorisation de conserver ses coordonnées dans notre base de données durant la durée légale 
- Photo de l’incivilité, le piéton pourra joindre ou prendre directement une photo depuis son Smartphone, cette photo sera associée au signalement de l’incivilité.

Toutes ces informations seront soumises à relecture sous leur forme finale au piéton donneur d’alerte avant leur envoi par mail au service communal concerné.
Les données ainsi récoltées donneront lieu à la création d’une base de données cette base de données gérera de façon automatisée la conservation légale des informations reçues. Après le délai réglementaire de conservation de ces données une autre automatisation permettra de conserver les données factuelles des incidents relatés sans les données personnelles afin d’alimenter des statistiques tout en respectant les règles de conservations de données personnelles inhérentes au web.
Un tableau de bord accessible par login et mot de passe sécurisé vous permettra de consulter et d’administrer les fonctionnalités de ce site et d’en extraire des rapports détaillés.
Ce formulaire et les fonctionnalités décrites ci-dessus sont réalisable grâce à une partie « back-end » qui nécessite un serveur qui me permet d’utiliser le langage PHP, un site dédié à cette application 
Pour la réalisation de ce formulaire tel que décrit ci-dessus, la création d’un nouveau nom de domaine (par exemple, « trottoirpropre.be » ) associé à un autre hébergement sera nécessaire. 
Comme évoqué lors de notre précédent rendez-vous, une page dédié du site Walk.brussels expliquera le service et mettra à disposition un lien pour accéder à l’application.
