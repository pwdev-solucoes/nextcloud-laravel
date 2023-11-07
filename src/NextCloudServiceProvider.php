<?php

namespace PWDev\NextCloudStorage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Sabre\DAV\Client;

class NextCloudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('nextcloud', function ($app, $config) {

//            $pathPrefix = array_key_exists('pathPrefix', $config) ? $config['pathPrefix'] : null;
            $pathPrefix = 'remote.php/dav/files/' . $config['userName'];
            if (array_key_exists('pathPrefix', $config)) {
                $pathPrefix = rtrim($config['pathPrefix'], '/') . '/' . $pathPrefix;
            }

            $client = new Client([
                'baseUri' => $config['baseUri'],
                'userName' => $config['userName'],
                'password' => $config['password']
            ]);

//            $client = new Client($config);
            $adapter = new NextCloudAdapter($client, $pathPrefix, $config);

            return new Filesystem($adapter);
        });
    }

    public function register()
    {

    }
}
