PACKAGE COMPOSER:

php package for a sdk rest api abstraction

package name: joussin/sdk-rest-api

version : dev-release ou tag 0.0.2

"joussin/sdk-rest-api": "dev-release"

"joussin/sdk-rest-api": "0.0.2" ( release github with tag 0.0.2 )

composer.json du package:

{
"name": "joussin/sdk-rest-api",

    "type": "package",
    "require": {
        "php": "^8.0.2",
        "guzzlehttp/guzzle": "^7.2"
    },
    "autoload": {
        "psr-4": {
            "SdkRestApi\\": "./"
        }
    },

    "description": "base laravel project",
    "license": "proprietary",
    "authors": [
        {
            "name": "Joussin Stéphane",
            "email": "joussin@live.com"
        }
    ]
}


package namespace:

    SdkRestApi/

package implementations:

    SdkRestApi/Infrastructure/Providers/Laravel/PackageServiceProvider



Pour ajouter ce package à un projet. Dans le composer.json du projet:
    
    "repositories": [
    
        {
        "type": "vcs",
        "url": "https://github.com/joussin/sdk-rest-api.git"
        }
    
    ],
    
    
    "require": {
     ...
        "joussin/sdk-rest-api": "0.0.2"
    },
    
    
si besoin:
    
        "autoload": {
            "psr-4": {
                ...
                "SdkRestApi\\": "sdk-rest-api/",

// ----------------------------------------------------------------------
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------

GITHUB: configuration projet


clef ssh de deploiement par projet:

generate key:

    ssh-keygen -t ed25519 -C "email@domain.com"
    


add key to agent:

    eval "$(ssh-agent -s)"
    
    sudo ssh-add --apple-use-keychain ~/.ssh/id_ed25519_sdk_rest
    sudo ssh-add --apple-use-keychain ~/.ssh/id_ed25519_laravel_package



read key: 

    cat /Users/waripay/.ssh/id_ed25519_sdk_rest.pub

liste keys ssh-agent:
    ssh-add -l

liste keys files:
    ls -l ~/.ssh

ssh conf:

    open ~/.ssh/config
    cat ~/.ssh/config
   

git conf:

    cat .git/config

1 repo: 

Host *.github.com
  AddKeysToAgent yes
  UseKeychain yes
  IdentityFile=cat /Users/waripay/.ssh/id_ed25519.pub


OU pour 2 repo:

Host sdk-rest-api
  HostName github.com
  AddKeysToAgent yes
  UseKeychain yes
  IdentityFile=~/.ssh/id_ed25519_sdk_rest

Host laravel-package
  HostName github.com
  AddKeysToAgent yes
  UseKeychain yes
  IdentityFile=~/.ssh/id_ed25519_laravel_package




add remote url with host:

clone:

    git clone git@<myHost>:aprilmintacpineda/chat-with-people-backend.git
    
    git clone git@sdk-rest-api:joussin/sdk-rest-api.git


add remote url:

    git remote add origin git@<myHost>:aprilmintacpineda/chat-with-people-backend.git
    git remote add origin git@sdk-rest-api:joussin/sdk-rest-api.git


voir les remotes url:

    git remote -v
    git config --get remote.origin.url

modifier :


    git remote set-url origin git@sdk-rest-api:joussin/sdk-rest-api.git
    git remote set-url origin git@laravel-package:joussin/laravel-package.git



