<?php

namespace OctavioCaba\ModuleCommandsLaravelPackage\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeControllerCommand extends GeneratorCommand
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:module-controller {name} {module} {--force} {--namespace-root=}';

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
    return app_path("Modules/{$module}/src/Http/Controllers/{$name}.php");
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

  /**
   * Execute the console command.
   */
  public function handle(): int
  {
    $name = $this->argument('name');
    $module = $this->argument('module');

    // Determine class name (without namespace) and target paths
    $className = preg_replace('/.*\\\\/', '', $name);

    $stubPath = $this->getStub();
    if (!is_file($stubPath)) {
      $this->error("Stub file not found: {$stubPath}");
      return 1;
    }

    $stub = file_get_contents($stubPath);

    // Build namespace for module controllers using provided option or configured root (default: Modules)
    $studlyModule = Str::studly($module);
    $namespaceRoot = $this->option('namespace-root') ?: config('module-commands.module_namespace', 'Modules');
    $namespaceRoot = trim($namespaceRoot, '\\');
    $classNamespace = $namespaceRoot . "\\{$studlyModule}\\Http\\Controllers";

    // Replace placeholders in stub
    $content = str_replace('$CLASS_NAMESPACE$', $classNamespace, $stub);
    $content = str_replace('$CLASS$', $className, $content);

    // Destination file under app/Modules/{module}/Http/Controllers/{Class}.php
    $destPath = app_path("Modules/{$module}/src/Http/Controllers/{$className}.php");
    $dir = dirname($destPath);
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    // If file exists, confirm overwrite unless --force provided
    if (file_exists($destPath) && !$this->option('force')) {
      if (!$this->confirm("{$destPath} already exists. Overwrite?")) {
        $this->info('Command cancelled.');
        return 0;
      }
    }

    // Write file
    file_put_contents($destPath, $content);

    $this->info("Created controller: {$destPath}");

    return 0;
  }

}
