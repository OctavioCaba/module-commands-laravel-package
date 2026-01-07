<?php

namespace OctavioCaba\ModuleCommandsLaravelPackage;

use Illuminate\Support\ServiceProvider;
use OctavioCaba\ModuleCommandsLaravelPackage\Console\Commands\MakeControllerCommand;

class ModuleCommandsLaravelPackageServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        MakeControllerCommand::class,
      ]);
    }
  }
}
