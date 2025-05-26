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
- Un compte AWS avec un bucket S3 configuré

---

## Installation

1. Cloner le dépôt

```bash
git clone https://github.com/ton-compte/monprojet.git
cd monprojet
