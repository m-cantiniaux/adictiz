# Adictiz

Développer une application backend qui permet aux visiteurs de notre site d'uploader des images. Ces images seront stockées dans un bucket S3 ou Google Cloud Storage, selon tes connaissances. En tant qu'administrateur, nous devons pouvoir accéder à une interface sécurisée par email et mot de passe, qui affiche une liste paginée des images uploadées.

---

## Contraintes techniques :
- Langage : PHP8
- Framework : Symfony 6.4
- Stockage : Utilisez AWS S3 ou Google Cloud Storage pour stocker les images.
- Base de données : MySQL
- Authentification : Implémentez une méthode d'authentification sécurisée pour l'accès à l'interface administrateur.
- Pour l'api: Pas d'utilisation d'api plateforme

## Prérequis

- [Docker](https://docs.docker.com/get-docker/) installé
- [DDEV](https://ddev.readthedocs.io/en/stable/) (installation automatique via script disponible)
- [Composer](https://getcomposer.org/)

---

## Installation

1. Cloner le dépôt

```bash
git clone https://github.com/m-cantiniaux/adictiz.git
cd adictiz
```

2. Installer les dépendances PHP avec Composer

```bash
composer install
```

3. Démarrage de l’environnement avec DDEV

```bash
ddev start
```

4. Exécuter les migrations Doctrine pour créer la structure des tables :

```bash
ddev php bin/console doctrine:migrations:migrate
```

5. Charger les fixtures pour préremplir la base (User)

```bash
ddev php bin/console doctrine:fixtures:load
```

6. Ajouter les variables d'environnement dans le fichier .env.local

```bash
AWS_BUCKET=votre-bucket
AWS_REGION=region
AWS_ACCESS_KEY_ID=accesskey
AWS_SECRET_ACCESS_KEY=secretkey
```

7. Login pour le test

```bash
max@bee-factory.be / adictiz
```
