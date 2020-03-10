<?php


namespace Hanson\LaravelAdminAlioss;


use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class AliossServiceProvider extends ServiceProvider
{
    public function boot(Alioss $extension)
    {
        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'alioss');
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        Admin::booting(function () {
            Form::extend('aliossImages', AliossImages::class);
        });
    }
}
