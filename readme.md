## Installation


You can install the package via composer:

```bash
"repositories": [
    
        {
        "type": "vcs",
        "url": "https://github.com/joussin/mbc-api-content-client-sdk.git"
        }
    
    ]
```
Choose version by tag:
```bash
    "require": {
        "joussin/mbc-api-content-client-sdk": "0.0.2"
    }
```
Or branch:
```bash
    "require": {
        "joussin/mbc-api-content-client-sdk": "dev-master"
    }
```

```bash
    composer update
```

After the package is installed, publish:
- the config file

```bash
php artisan vendor:publish --provider=MbcApiContentSdk\\\Providers\\PackageServiceProvider
```

## Configuration

config/mbc-api-content-client-sdk.php
    - api url
    - api credentials
    - ...

```php
return [
    'api' => [
        'base_url' => '',
        'credentials' => [
            'client_id' => '',
            'client_secret' => '',
        ],

        'routes' => [
            'prefix' => 'api/v1'
        ]
    ],
];
```


## Boot sdk

```php
use Illuminate\Support\ServiceProvider;
   
    class AppServiceProvider extends ServiceProvider
    {
        public function boot(\MbcApiContentSdk\ApplicationApiContentSdk $bootstrap)
        {
            $bootstrap->init();
        }
    }
```

## Liste des routes:
``` bash
php artisan route:list  
php artisan route:list --except-vendor
```


## Facades

ApiSdkFacade : ApiSdkService

```php


ApiSdkFacade::Route->search()

RouterFacade::routesCollection()

```




## Obtenir une instance du SDK:

- Intégrer le sdk dans l'app laravel

    - récupérer une instance via le provider:
      $instance = make ApplicationApiContentSdkInterface -> ApplicationApiContentSdk
      $instance->API->...

    - via une Facade :
      ApiContentSdkFacade::API->...
      ApiContentSdkFacade::ROUTER->...

## Architecture SDK:


L'instance du sdk possède plusieurs instances de Services pour chacun de ses métiers.


- RestClient :
    - Métier : permettant la communication avec l'api content
    - Dépendances : Guzzle client & config file


- ApiContentService:
    - Métier : Transforme les réponses du client en Objets (entity et entityCollection) facilement manipulable
    - Dépendances : RestClient

    - Example:

      ApiContentSdkFacade::API->Route->all() : RouteEntityCollection
      ApiContentSdkFacade::API->Route->id(1) : RouteEntity
      ...
      ApiContentSdkFacade::API->Page->all() : PageEntityCollection
      ApiContentSdkFacade::API->Page->id(1) : PageEntity
      ...
      ApiContentSdkFacade::API->PageContent->all() : PageContentEntityCollection
      ApiContentSdkFacade::API->PageContent->id(1) : PageContentEntity      
      ...



- RouterService
    - Métier :
        - Transforme RouteEntityCollection en routes laravel
        - store ces routes dans le router de laravel avec le RouterMiddleware
        - RouterMiddleware : handle server request et retourne une response html
    - Dépendances : ApiContentService

    - Example:
      ApiContentSdkFacade::ROUTER->store( ApiContentSdkFacade::API->Route->all() )


- ExportService : code & commande console
    - Métier : exporte les routes laravel sous forme de routes statiques avec contenu html statique
    - Dépendances :
        - RouterService
        - joussin/laravel-export : fork de spatie/laravel-export

    - Example:
        - code dans provider->boot() par ex:
          ApiContentSdkFacade::EXPORT->paths( ApiContentSdkFacade::ROUTER->all() )

        - commande:
          php artisan export








NOTES:


    - Entity/Synchronization_Api_with_Frontal (SynchronizationEntity)
        - expose endpoint or broadcast system or queue or ... to listen for api update
            - if backoffice or api update Route or Page or PageContent, api dispatch event to
                exposed endpoint
            - SynchroService handle api update event

            
        - SynchronizationService  (inject SdkService - ExportService to update static files)
              - handle exposed endpoint request : Entity/Synchronization_Api_with_Frontal
              - Export new files via ExportService: 
                - update route list
                - update route page
                - update route pageContent
                - update static content
