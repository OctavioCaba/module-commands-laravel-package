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
    // Merge package configuration
    $this->mergeConfigFrom(__DIR__ . '/../config/module-commands.php', 'module-commands');
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Publish config
    if ($this->app->runningInConsole()) {
      $this->publishes([
        __DIR__ . '/../config/module-commands.php' => config_path('module-commands.php'),
      ], 'config');

      $this->commands([
        MakeControllerCommand::class,
      ]);
    }
  }
}
