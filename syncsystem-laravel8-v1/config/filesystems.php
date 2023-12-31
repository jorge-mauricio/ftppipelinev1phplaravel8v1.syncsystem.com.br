<?php

// require __DIR__ . '/../config-application.php'; // SyncSystem customized configuration. // error - language load function

// Variables.
$productionPublicPath = '';
$arrSymLinks = [];

// Debug.
// Load frontend to check the output.
// dump('edit=6');
// dump(base_path());
// dump(app_path());
// dump(public_path());
// dump(realpath(__DIR__ . '/../../') . config('app.gSystemConfig.configDirectoryFilesSD'));
// dump(realpath(dirname(__FILE__) . '/../../'));
// dump(
//     realpath(
//         dirname(__FILE__) .
//         DIRECTORY_SEPARATOR . '..' .
//         DIRECTORY_SEPARATOR . '..' .
//         DIRECTORY_SEPARATOR
//     ) .
//     DIRECTORY_SEPARATOR .
//     config('app.gSystemConfig.configDirectoryFilesSD')
// );
// dump($productionPublicPath . config('app.gSystemConfig.configDirectoryFilesSD'));
// dump(config('app.gSystemConfig.configPhysicalPathRootPublicWeb'));
// dump(storage_path('app' . DIRECTORY_SEPARATOR . config('app.gSystemConfig.configDirectoryFiles')));

// Define values.
if (config('app.gSystemConfig.configSystemEnv') === 'local') {
    $arrSymLinks = [
        // public_path('storage') => storage_path('app/public'),
        // public_path(env('CONFIG_DIRECTORY_FILES_SD')) => storage_path('app/' . env('CONFIG_DIRECTORY_FILES')), // working
        // public_path(config('app.gSystemConfig.configDirectoryFilesSD')) => storage_path(config('app.gSystemConfig.configDirectoryFiles')),
        public_path(config('app.gSystemConfig.configDirectoryFilesSD')) => storage_path('app' . DIRECTORY_SEPARATOR . config('app.gSystemConfig.configDirectoryFiles')),
        // public_path('files-layout') => resource_path('app_files_layout'),
        // public_path($GLOBALS['configDirectoryFilesLayoutSD']) => resource_path('app_files_layout'),
        // public_path(config('app.configDirectoryFilesLayoutSD')) => resource_path('app_files_layout'), // working
        // public_path(env('CONFIG_DIRECTORY_FILES_LAYOUT_SD')) => resource_path('app_files_layout'), // working
        // public_path(env('CONFIG_DIRECTORY_FILES_LAYOUT_SD')) => resource_path(env('CONFIG_DIRECTORY_FILES_LAYOUT')), // working
        public_path(config('app.gSystemConfig.configDirectoryFilesLayoutSD')) => resource_path(config('app.gSystemConfig.configDirectoryFilesLayout')),
        // public_path('app_resources') => resource_path('app_resources'),
        // public_path('fonts') => resource_path('app_fonts'),
        // public_path(env('CONFIG_DIRECTORY_FONTS_SD')) => resource_path(env('CONFIG_DIRECTORY_FONTS')), // working
        public_path(config('app.gSystemConfig.configDirectoryFontsSD')) => resource_path(config('app.gSystemConfig.configDirectoryFonts')),
        // TODO: maybe use function to get value from config.
    ];
} elseif (config('app.gSystemConfig.configSystemEnv') === 'production') {
    // $productionPublicPath = realpath(
    //     __DIR__ .
    //     // dirname(__FILE__) .
    //     DIRECTORY_SEPARATOR . '..' .
    //     DIRECTORY_SEPARATOR . '..' .
    //     DIRECTORY_SEPARATOR
    // ) .
    // DIRECTORY_SEPARATOR; // Map the public web html root directory.
    $productionPublicPath = config('app.gSystemConfig.configPhysicalPathRootPublicWeb') . DIRECTORY_SEPARATOR;

    $arrSymLinks = [
        $productionPublicPath . config('app.gSystemConfig.configDirectoryFilesSD') => storage_path('app' . DIRECTORY_SEPARATOR . config('app.gSystemConfig.configDirectoryFiles')),
        $productionPublicPath . config('app.gSystemConfig.configDirectoryFilesLayoutSD') => resource_path(config('app.gSystemConfig.configDirectoryFilesLayout')),
        $productionPublicPath . config('app.gSystemConfig.configDirectoryFontsSD') => resource_path(config('app.gSystemConfig.configDirectoryFonts')),
    ];
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'), // TODO: maybe modify this to point to storage/app_files_public and update \config\filesystems.php, file upload, file resize and config file.
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            // 'root' => '/var/www/multiplatformphplaravel8v1.syncsystem.com.br/www',
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            // TODO: update with config files
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */
    'links' => $arrSymLinks,
];
