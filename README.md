# P7-BileMo

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/05b86a0fd9a94d6290d213d4fb3dd6b8)](https://app.codacy.com/app/sorha/P7-BileMo?utm_source=github.com&utm_medium=referral&utm_content=sorha/P7-BileMo&utm_campaign=Badge_Grade_Dashboard)

Création d'une API Rest pour BileMo, une entreprise de vente de téléphone fictive.

## Environnement utilisé durant le développement
* Symfony 4.2
* Composer 1.8.0
* WampServer 3.1.7
    * Apache 2.4.37
    * PHP 7.3.1
    * MySQL 5.7.24 (5.7.8 minimum pour l'utilisation du champs JSON !)

## Informations sur l'API
* L'obtention du token afin de s'authentifier à l'API se fait via l'envoie des identifiants sur l'URI /api/login_check
* Les opérations "GET" sont accéssibles à tout utilisateur authentifié. 
* Par sécurité, les autres opérations (POST/PUT/DELETE) ne sont accéssibles qu'aux utilisateurs qui possédent le rôle ROLE_ADMIN.

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    git clone https://github.com/sorha/P7-BileMo.git
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier `.env.local` qui devra être crée à la racine du projet en réalisant une copie du fichier `.env`.

3. Téléchargez et installez les dépendances du projet avec [Composer](https://getcomposer.org/download/) :
```
    composer install
```
4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    php bin/console doctrine:database:create
```
5. Créez les différentes tables de la base de données en appliquant les migrations :
```
    php bin/console doctrine:migrations:migrate
```
6. Générez les clés SSH ([Solution alternative pour OpenSSL sur Windows](https://slproweb.com/products/Win32OpenSSL.html))
Et noter votre passphrase à la ligne "JWT_PASSPHRASE=" de votre fichier `.env.local`
```bash
$ mkdir config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
7. (Optionnel) Installez les fixtures pour avoir une démo de données fictives :
```
    php bin/console doctrine:fixtures:load
```
8. Félicitations le projet est installé correctement, vous pouvez désormais commencer à l'utiliser à votre guise !