<?php


namespace SdkRestApi\Providers\Laravel;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use SdkRestApi\RestSdk\RestClient\RestClientService;
use SdkRestApi\RestSdk\RestClient\RestClientServiceInterface;
use SdkRestApi\RestSdk\Services\SdkService;
use SdkRestApi\RestSdk\Services\SdkServiceInterface;


class PackageServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $this->app->bind(RestClientServiceInterface::class, function($app){
            return new RestClientService(
                app()->make(ClientInterface::class)
            );
        });

        $this->app->bind(ClientInterface::class, function(){
            return new Client([
                'base_uri' => env('API_URL'),
                'http_error' => true
            ]);
        });

        $this->app->bind(SdkServiceInterface::class, function(){
            return new SdkService(
                app()->make(RestClientServiceInterface::class)
            );
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }




}
