<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Communication\Connection\ConnectionInterface;
use App\Services\Communication\Connection\Connection;
use App\Services\Communication\Sender\SenderInterface;
use App\Services\Communication\Sender\Sender;
use GuzzleHttp\Client;

class ServicesProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->app->configPath('communication.php'), 'communication');

        $this->app->bind(
            ConnectionInterface::class,
            function ($app, array $parameters) {
                $key = isset($parameters['key']) ? $parameters['key'] : null;
                $config = config('communication.connections', []);

                $connection = new Connection();
                if ( isset($config[$key]) ) {
                    $connection->setUrl($config[$key]['url'] ?? '');
                    $connection->addHeaders($config[$key]['headers'] ?? []);
                }

                return $connection;
            }
        );

        $this->app->bind(
            SenderInterface::class,
            function ($app, array $parameters) {

                $client = new Client();
                $connection = $app->make(ConnectionInterface::class, $parameters);    
                $sender = new Sender($connection, $client);
                return $sender;
            }
        );
    }
    
    public function provides() 
    {
        return [
            SenderInterface::class
        ];
    }
}
