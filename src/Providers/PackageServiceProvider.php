<?php


namespace MbcApiContentSdk\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use MbcApiContent\Providers\RouteServiceProvider;
use MbcApiContentSdk\ApplicationApiContentSdk;
use MbcApiContentSdk\ApplicationApiContentSdkInterface;
use MbcApiContentSdk\Entity\Page\PageEntity;
use MbcApiContentSdk\Entity\Page\PageEntityInterface;
use MbcApiContentSdk\Entity\PageContent\PageContentEntity;
use MbcApiContentSdk\Entity\PageContent\PageContentEntityInterface;
use MbcApiContentSdk\Entity\Route\RouteEntity;
use MbcApiContentSdk\Entity\Route\RouteEntityInterface;
use MbcApiContentSdk\Entity\Synchronization\SynchronizationEntity;
use MbcApiContentSdk\Entity\Synchronization\SynchronizationEntityInterface;
use MbcApiContentSdk\RestClient\RestClient;
use MbcApiContentSdk\RestClient\RestClientInterface;
use MbcApiContentSdk\Services\ApiContentService;
use MbcApiContentSdk\Services\ApiContentServiceInterface;
use MbcApiContentSdk\Services\RouterService;
use MbcApiContentSdk\Services\RouterServiceInterface;

class PackageServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        // INTEGRATION SDK
        // permet d'intégrer le sdk à une app laravel
        // via une instance obtenu avec ApplicationApiContentSdkInterface
        // via la facacde ApiSdkFacade::
        $this->app->singleton('api_content_sdk_facade_accessor', function ($app) {
            return $app->make(ApplicationApiContentSdkInterface::class);
        });

        $this->app->singleton(ApplicationApiContentSdkInterface::class, function($app){
            return new ApplicationApiContentSdk();
        });


        // services de l'app

        // recupere les resources de l'api
        $this->app->bind(ApiContentServiceInterface::class, function($app){
            return new ApiContentService(
                $app->make(RouteEntityInterface::class),
                $app->make(PageEntityInterface::class),
                $app->make(PageContentEntityInterface::class),
                $app->make(SynchronizationEntityInterface::class),
            );
        });


        // créer un router grâce aux resources
        $this->app->bind(RouterServiceInterface::class, function($app){
            return new RouterService();
        });






        // client
        $this->app->bind(RestClientInterface::class, function($app){
            return new RestClient(
                $app->make(ClientInterface::class),
                config('mbc_api_content_client_sdk')['api']['prefix']
            );
        });

        $this->app->bind(ClientInterface::class, function(){
            return new Client([
                'base_uri' => config('mbc_api_content_client_sdk')['api']['base_url'],
                'http_error' => true
            ]);
        });


        // entity

        $this->app->bind(PageEntityInterface::class, function($app){
            return new PageEntity(
                $app->make(RestClientInterface::class),
            );
        });

        $this->app->bind(PageContentEntityInterface::class, function($app){
            return new PageContentEntity(
                $app->make(RestClientInterface::class),
            );
        });

        $this->app->bind(RouteEntityInterface::class, function($app){
            return new RouteEntity(
                $app->make(RestClientInterface::class),
            );
        });

        $this->app->bind(SynchronizationEntityInterface::class, function($app){
            return new SynchronizationEntity(
                $app->make(RestClientInterface::class),
            );
        });


        // config

        $this->mergeConfigFrom(
            file_exists( config_path('mbc-api-content-client-sdk.php') ) ? config_path('mbc-api-content-client-sdk.php') : (__DIR__ . './../../config/mbc-api-content-client-sdk.php') ,
            'mbc_api_content_client_sdk'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            try{

                $this->publishes([
                    __DIR__.'/../../config/mbc-api-content-config.php' => config_path('mbc-api-content-config.php'),
                ]);


            }
            catch (\Exception $e)
            {
                throw new \Exception('Error installing ' . $e->getMessage());
            }
        }
    }




}
