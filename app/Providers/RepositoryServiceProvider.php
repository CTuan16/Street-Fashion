<?php

namespace App\Providers;


use App\Contract\Hi_FPT\SettingInterface;

use App\Models\Settings;


use App\Repository\Hi_FPT\SettingRepository;

use App\Repository\RepositoryAbstract;
use App\Repository\RepositoryInterface;
use Illuminate\Support\ServiceProvider;
// Auto Generate

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Bind Provider
        $this->app->bind(RepositoryInterface::class, RepositoryAbstract::class);  
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(SettingInterface::class, function () {
            return new SettingRepository(new Settings());
        });
    }

}
