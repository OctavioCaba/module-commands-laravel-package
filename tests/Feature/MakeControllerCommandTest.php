<?php

namespace Tests\Feature;

use OctavioCaba\ModuleCommandsLaravelPackage\Console\Commands\MakeControllerCommand;
use Tests\TestCase;

class TestableMakeControllerCommand extends MakeControllerCommand
{
  public function __construct(\Illuminate\Filesystem\Filesystem $files)
  {
    parent::__construct($files);
  }

  public function argument($key = null)
  {
    if ($key === 'module') {
      return 'Blog';
    }

    return parent::argument($key);
  }

  public function callGetStub()
  {
    return $this->getStub();
  }

  public function callGetDefaultNamespace($root)
  {
    return $this->getDefaultNamespace($root);
  }

  public function callGetDestinationClassPath($name)
  {
    return $this->getDestinationClassPath($name);
  }
}

class MakeControllerCommandTest extends TestCase
{
  public function test_get_stub_and_namespaces_and_destination_path()
  {
    // Create a small test subclass to expose protected methods and simulate arguments
    $files = $this->app->make(\Illuminate\Filesystem\Filesystem::class);

    $testCommand = new TestableMakeControllerCommand($files);

    // Assert stub path exists and points to the stub file
    $stubPath = $testCommand->callGetStub();
    $this->assertIsString($stubPath);
    $this->assertFileExists($stubPath, 'Expected the controller stub file to exist');

    // Assert default namespace behavior
    $default = $testCommand->callGetDefaultNamespace('App');
    $this->assertSame('App\\Http\\Controllers', $default);

    // Assert destination class path uses the provided module argument
    $dest = $testCommand->callGetDestinationClassPath('UserController');

    // Normalize separators for assert
    $normalized = str_replace('\\', '/', $dest);
    $this->assertStringEndsWith('/modules/Blog/Http/Controllers/UserController.php', $normalized);
  }
}
