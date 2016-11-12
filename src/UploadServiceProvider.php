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

    public function boot(Route $router){
        parent::boot($router);
        $this->loadViewsFrom(__DIR__.'/views', 'upload');
        $this->map($router);
    }

    public function register()
    {
        // TODO: Implement register() method.

        $configPath = __DIR__ . '/config/upload.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('upload.php');
        } else {
            $publishPath = base_path('config/upload.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }
    public function map(Route $router)
    {
        $this->mapWebRoutes($router);

        //
    }
    public function mapWebRoutes(Route $router){
        $router::group([
            'namespace'  => $this->namespace,
            'middleware' => ['web']
        ], function($router) {
            require (__DIR__.'/Http/routes.php');
        });
    }
}
