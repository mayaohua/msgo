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
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        // dd($_SERVER);
        try {
            $sld_prefix = explode('.',$_SERVER['HTTP_HOST'])[0];
        // dd($sld_prefix);
            if('msgo' == $sld_prefix){
                $this->mapWebRoutes();
            }elseif('wx' == $sld_prefix){
                $this->mapWxRoutes();
            }elseif('api' == $sld_prefix){
                $this->mapApiRoutes();
            }elseif('xyz' == $sld_prefix){
                $this->mapAdminRoutes();
            }
        } catch (\Throwable $th) {
            
        }
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
        Route::middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdminRoutes()
    {
        //prefix('xy')
        Route::middleware('admin')
             ->namespace($this->namespace)
             ->group(base_path('routes/admin.php'));
    }

    protected function mapWxRoutes()
    {
        Route::middleware('wx')
             ->namespace($this->namespace)
             ->group(base_path('routes/wx.php'));
    }

    
}
