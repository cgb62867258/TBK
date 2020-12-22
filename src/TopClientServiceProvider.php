<?php

namespace Wangma\TopClient;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as baseServiceProvider;

class TopClientServiceProvider extends baseServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/taobaotop.php');
        $this->publishes([$source => config_path('taobaotop.php')]);
        $this->mergeConfigFrom($source, 'taobaotop');
        $this->defineConstant();
    }

    protected function defineConstant()
    {
        /*
         * 定义常量开始
         * 在include("TopSdk.php")之前定义这些常量，不要直接修改本文件，以利于升级覆盖
         */
        /*
         * SDK工作目录
         * 存放日志，TOP缓存数据
         */
        if (!defined('TOP_SDK_WORK_DIR')) {
            define('TOP_SDK_WORK_DIR', '/tmp/');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerFactory($this->app);
        $this->registerManager($this->app);
    }

    /**
     * Register the factory class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    protected function registerFactory(Application $app)
    {
        $app->singleton('topclient.factory', function ($app) {
            return new Factories\TopClientFactory();
        });
        $app->alias('topclient.factory', 'Remxcode\TopClient\Factories\TopClientFactory');
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('topclient', function ($app) {
            $config = $app['config'];
            $factory = $app['topclient.factory'];

            return new Manager($config, $factory);
        });
        $app->alias('topclient', 'Remxcode\TopClient\Manager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'topclient',
            'topclient.factory',
        ];
    }
}
