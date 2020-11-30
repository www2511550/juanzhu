<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
//    protected $namespace = 'App\Http\Controllers';
    protected $namespace = 'App';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        include app_path('include/functions.php');
        include app_path('include/main.inc.php');
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapDaidaiRoutes();
        
        $this->mapToolRoutes();
        $this->mapBlogRoutes();

        $this->mapDapeiRoutes();

        $this->mapPlanRoutes();

        $this->mapUrlRoutes();
        $this->mapSRoutes();

        $this->mapApiRoutes();

        $this->mapWebRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
//             ->group(base_path('routes/dapei.php'));
//             ->group(base_path('routes/url.php'));
//             ->group(base_path('routes/daidai.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    public function mapPlanRoutes()
    {
        Route::group([
            'domain' => 'plan.juanzhuzhu.com',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/plan.php');
        });
    }

    public function mapUrlRoutes()
    {
        Route::group([
            'domain' => 'url.juanzhuzhu.com',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/url.php');
        });
        Route::group([
            'domain' => 'url.51wz.com.cn',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/url.php');
        });
    }

    public function mapSRoutes()
    {
        Route::group([
            'domain' => 's.juanzhuzhu.com',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/url.php');
        });
        Route::group([
            'domain' => 's.51wz.com.cn',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/url.php');
        });

    }

    public function mapToolRoutes()
    {
        Route::group([
            'domain' => 'tool.juanzhuzhu.com',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/tool.php');
        });
    }

    public function mapBlogRoutes()
    {
        Route::group([
            'domain' => '51wz.com.cn',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/blog.php');
        });
    }

    public function mapDapeiRoutes()
    {
        Route::group([
            'domain' => '2dapei.com.cn',
//            'domain' => env('APP_DEBUG') ? 'm.test.com':  '2dapei.com.cn',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/dapei.php');
        });

        Route::group([
            'domain' => 'www.2dapei.com.cn',
//            'domain' => env('APP_DEBUG') ? 'm.test.com':  'www.2dapei.com.cn',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/dapei.php');
        });
    }

    public function mapDaidaiRoutes()
    {
        Route::group([
            'domain' => 'daidai.juanzhuzhu.com',
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/daidai.php');
        });
    }
}
