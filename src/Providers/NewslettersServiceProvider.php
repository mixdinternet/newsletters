<?php

namespace Mixdinternet\Newsletters\Providers;

use Illuminate\Support\ServiceProvider;
use Pingpong\Menus\MenuFacade as Menu;

class NewslettersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setMenu();
        $this->setRoutes();
        $this->loadViews();
        $this->loadMigrations();
        $this->publish();
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function setMenu()
    {
        Menu::modify('adminlte-sidebar', function ($menu) {
            $menu->route('admin.newsletters.index', config('mnewsletters.name', 'Artigos'), [], config('mnewsletters.order', 20)
                , ['icon' => config('mnewsletters.icon', 'fa fa-envelope'), 'active' => function () {
                    return checkActive(route('admin.newsletters.index'));
                }])->hideWhen(function () {
                return checkRule('admin.newsletters.index');
            });
        });

        Menu::modify('adminlte-permissions', function ($menu) {
            $menu->url('admin.newsletters', config('mnewsletters.name', 'Artigos'), config('mnewsletters.order', 20));
        });
    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Newsletters\Http\Controllers'],
                function () {
                    require __DIR__ . '/../routes/web.php';
                });
        }
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/newsletters');
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maudit.php', 'maudit.alias');
        $this->mergeConfigFrom(__DIR__ . '/../config/mnewsletters.php', 'mnewsletters');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/newsletters'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
        ], 'config');
    }
}