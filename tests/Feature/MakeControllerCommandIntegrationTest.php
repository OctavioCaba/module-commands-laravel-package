<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeControllerCommandIntegrationTest extends TestCase
{
  public function test_artisan_creates_controller_and_replaces_stub_placeholders()
  {
    $name = 'IntegrationTestController';
    $module = 'querylog';

    $dest = app_path("modules/{$module}/src/Http/Controllers/{$name}.php");

    // Ensure clean state before running
    if (file_exists($dest)) {
      @unlink($dest);
    }

    // Run the artisan command
    $this->artisan('make:module-controller', [
      'name' => $name,
      'module' => $module,
    ])->assertExitCode(0);

    // Assert file created
    $this->assertFileExists($dest);

    $contents = file_get_contents($dest);

    // Namespace should be present and class name replaced
    $this->assertStringContainsString('namespace Modules\\Querylog\\Http\\Controllers', $contents);
    $this->assertStringContainsString('class ' . $name, $contents);

    // Cleanup
    @unlink($dest);
    // remove directories if empty
    @rmdir(app_path("modules/{$module}/Http/Controllers"));
    @rmdir(app_path("modules/{$module}/Http"));
    @rmdir(app_path("modules/{$module}"));
  }
}
