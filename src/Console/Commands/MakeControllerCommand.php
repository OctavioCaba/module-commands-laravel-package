<?php

namespace OctavioCaba\ModuleCommandsLaravelPackage\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeControllerCommand extends GeneratorCommand
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:module-controller {name} {module}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new module controller';

  /**
   * Get the stub file for the generator.
   *
   * @return string
   */
  protected function getStub()
  {
    return __DIR__ . '/stubs/controller-plain.stub';
  }

  /**
   * Get the default namespace for the class.
   *
   * @param  string  $rootNamespace
   * @return string
   */
  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Http\Controllers';
  }

  /**
   * Get the destination class path.
   *
   * @param  string  $name
   * @return string
   */
  protected function getDestinationClassPath($name)
  {
    $module = $this->argument('module');
    $name = str_replace('\\', '/', $name);
    return app_path("modules/{$module}/Http/Controllers/{$name}.php");
  }

  /**
   * Build the class with the given name.
   *
   * @param  string  $name
   * @return string
   */
  protected function buildClass($name)
  {
    $stub = parent::buildClass($name);

    return $stub;
  }

}
