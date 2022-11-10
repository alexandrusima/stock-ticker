<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use App\Services\Communication\Sender\Sender;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Communication\Connection\Connection;
use App\Services\Communication\Sender\SenderInterface;
use App\Services\Communication\Connection\ConnectionInterface;
use App\Services\Communication\Mapping\MappingInterface;
use App\Services\Communication\Mapping\Mapper;
use App\Services\Communication\Receivers\TickerReceiver;
use App\Services\Communication\Receivers\TickerReceiverInterface;
use App\Services\Communication\Receivers\CompaniesReceiver;
use App\Services\Communication\Receivers\CompaniesReceiverInterface;

class CommunicationServiceProvider extends ServiceProvider implements DeferrableProvider
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
                if (is_null($key)) {
                    $key = config('communication.connections.default', null);
                }
                $config = config('communication.connections', []);

                $connection = new Connection();
                if (isset($config[$key])) {
                    $connection->setUrl($config[$key]['url'] ?? '');
                    $connection->addHeaders($config[$key]['headers'] ?? []);
                }

                return $connection;
            }
        );

        $this->app->bind(
            MappingInterface::class,
            function ($app, $parameters) {
                $key = array_key_exists('key', $parameters) ? $parameters['key'] : null;

                $config = config('communication.mapping.' . $key, []);
                return new Mapper($config);
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

        $this->app->singleton(
            CompaniesReceiverInterface::class,
            function ($app) {
                $sender = $app->make(SenderInterface::class, ['key' => 'companies']);
                $mapper = $app->make(MappingInterface::class, ['key' => 'companies']);

                return new CompaniesReceiver($sender, $mapper);
            }
        );

        $this->app->singleton(
            TickerReceiverInterface::class,
            function ($app) {
                $sender = $app->make(SenderInterface::class, ['key' => 'ticker']);
                $mapper = $app->make(MappingInterface::class, ['key' => 'ticker']);

                return new TickerReceiver($sender, $mapper);
            }
        );
    }

    public function provides()
    {
        return [
            CompaniesReceiverInterface::class,
            TickerReceiverInterface::class
        ];
    }
}
