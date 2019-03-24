# P7-BileMo

Création d'une API Rest pour BileMo, une entreprise de vente de téléphone fictive.

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
6. Générer les clés SSH ([Solution alternative pour OpenSSL sur Windows](https://slproweb.com/products/Win32OpenSSL.html))
Et noter votre passphrase à la ligne "JWT_PASSPHRASE=" de votre fichier `.env.local`
```bash
$ mkdir config/jwt
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
7. (Optionnel) Installer les fixtures pour avoir une démo de données fictives :
```
    php bin/console doctrine:fixtures:load
```
8. Félications le projet est installé correctement, vous pouvez désormais commencer à l'utiliser à votre guise !