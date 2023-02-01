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
        public function boot(\MbcApiContentSdk\BootstrapSdk $bootstrap)
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
RouterFacade : RouterService
```php


ApiSdkFacade::Route->search()
ApiSdkFacade::Route->getAll()
ApiSdkFacade::Route->getById()
ApiSdkFacade::Route->getByUri()

ApiSdkFacade::Page->search()
ApiSdkFacade::Page->getAll()
ApiSdkFacade::Page->getById()
ApiSdkFacade::Page->getByRoute()
ApiSdkFacade::Page->bladeTemplateName()

ApiSdkFacade::PageContent->search()
ApiSdkFacade::PageContent->getAll()
ApiSdkFacade::PageContent->getById()
ApiSdkFacade::PageContent->getByName()
ApiSdkFacade::PageContent->getByPage()


RouterFacade::routesCollection()
RouterFacade::staticRoutesCollection()
RouterFacade::requestHandlerCallback()
RouterFacade::contentParser()

```

## Architecture

 - Laravel Provider

    - ApplicationBootstrap

        - RestClient  (inject Guzzle client & config file)
            - call api

        - ApiSdkService: api call ReadOnly (inject RestClient)

            - Entity/Route
                - search by filter (RouteEntity or Collection)
                - get all routes (RouteEntityCollection)
                - get one route by id (RouteEntity)
                - get one route by url (RouteEntity)
                
            - Entity/Page
                - search by filter (PageEntity or Collection)
                - get all pages (PageEntityCollection)
                - get one page by id (PageEntity)

            - Entity/PageContent
                - search by filter (PageContentEntity or Collection)
                - get all PageContent (PageContentEntityCollection)
                - get one PageContent by id (PageContentEntity)
                - get one PageContent by name (PageContentEntity)

            - Entity/Synchronization_Api_with_Frontal (SynchronizationEntity)
                - expose endpoint or broadcast system or queue or ... to listen for api update
                    - if backoffice or api update Route or Page or PageContent, api dispatch event to
                      exposed endpoint
                    - SynchroService handle api update event

        - RouterService   (inject SdkService )
            - routes collection : RouteEntityCollection
            - handle server request
                - from dynamic uri
                - from static uri
            - Content Parser / Render HTML
                - SdkService::RouteEntity -> SdkService::PageEntity -> SdkService::pageContentsEntity
                    - server request to html
                    - blade template generator

        - ExportService - spatie/laravel-export (CONSOLE COMMAND) (inject RouterService)
            - generate static files from RouterService::routeEntityCollection

        - SynchronizationService  (inject SdkService - ExportService to update static files)
              - handle exposed endpoint request : Entity/Synchronization_Api_with_Frontal
              - Export new files via ExportService: 
                - update route list
                - update route page
                - update route pageContent
                - update static content
