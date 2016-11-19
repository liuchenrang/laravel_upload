<?php
namespace  EzApp\Upload;
/**
 * Created by PhpStorm.
 * User: XingHuo
 * Date: 16/6/25
 * Time: 下午7:34
 */
use  Illuminate\Support\ServiceProvider;
use Route;
class UploadServiceProvider  extends ServiceProvider
{
    protected $namespace = 'EzApp\Upload\Http\Conttrollers';


    public function register()
    {
        // TODO: Implement register() method.
        $this->loadViewsFrom(__DIR__.'/views', 'upload');

        $configPath = __DIR__ . '/config/upload.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('upload.php');
        } else {
            $publishPath = base_path('config/upload.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
        Route::group([
            'namespace'  => $this->namespace,
            'middleware' => ['web']
        ], function() {
            require (__DIR__.'/Http/routes.php');
        });

    }

}
