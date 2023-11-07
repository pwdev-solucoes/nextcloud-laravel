<?php

namespace PWDev\NextCloudStorage;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use Sabre\DAV\Client;

class NextCloudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('nextcloud', function ($app, $config) {


//            $pathPrefix = 'remote.php/dav/files/' . $config['userName'];
//            if (array_key_exists('pathPrefix', $config)) {
//                $pathPrefix = rtrim($config['pathPrefix'], '/') . '/' . $pathPrefix;
//            }
            $pathPrefix = array_key_exists('pathPrefix', $config) ? $config['pathPrefix'] : null;
            $client = new Client([
                'baseUri' => $config['baseUri'],
                'userName' => $config['userName'],
                'password' => $config['password']
            ]);

//            $client = new Client($config);
//            $adapter = new NextCloudAdapter($client, $pathPrefix, $config);

//            return new Filesystem($adapter);

            $adapter = new WebDAVAdapter($client, $pathPrefix);

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }

    public function register()
    {

    }
}
