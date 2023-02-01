<?php


namespace MbcApiContentSdk\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use MbcApiContentSdk\BootstrapSdk;
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
use MbcApiContentSdk\Services\ApiSdkService;
use MbcApiContentSdk\Services\ApiSdkServiceInterface;
use MbcApiContentSdk\Services\ExportService;
use MbcApiContentSdk\Services\ExportServiceInterface;
use MbcApiContentSdk\Services\RouterService;
use MbcApiContentSdk\Services\RouterServiceInterface;
use MbcApiContentSdk\Services\SynchronizationService;
use MbcApiContentSdk\Services\SynchronizationServiceInterface;

class PackageServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(BootstrapSdk::class, function($app){
            return new BootstrapSdk();
        });

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

        $this->app->bind(ApiSdkServiceInterface::class, function($app){
            return new ApiSdkService(
                $app->make(RouteEntityInterface::class),
                $app->make(PageEntityInterface::class),
                $app->make(PageContentEntityInterface::class),
                $app->make(SynchronizationEntityInterface::class),
            );
        });

        $this->app->bind(RouterServiceInterface::class, function($app){
            return new RouterService();
        });


        $this->app->bind(SynchronizationServiceInterface::class, function($app){
            return new SynchronizationService();
        });


        $this->app->bind(ExportServiceInterface::class, function($app){
            return new ExportService();
        });


        //

        // ApiSdkFacade::
        $this->app->singleton('sdk_service_facade_accessor', function ($app) {
            return $app->make(ApiSdkServiceInterface::class);
        });


        // SdkFacade::
        $this->app->singleton('router_service_facade_accessor', function ($app) {
            return $app->make(RouterServiceInterface::class);
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
