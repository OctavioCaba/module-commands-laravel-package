<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeControllerCommandConfigFallbackTest extends TestCase
{
  public function test_command_uses_default_namespace_when_config_missing()
  {
    $name = 'FallbackController';
    $module = 'querylog';

    $dest = app_path("modules/{$module}/src/Http/Controllers/{$name}.php");

    // Ensure clean state before running
    if (file_exists($dest)) {
      @unlink($dest);
    }

    // Remove package config key to simulate missing config
    $this->app['config']->set('module-commands', []);

    // Run the artisan command
    $this->artisan('make:module-controller', [
      'name' => $name,
      'module' => $module,
    ])->assertExitCode(0);

    // Assert file created and fallback namespace used
    $this->assertFileExists($dest);
    $contents = file_get_contents($dest);
    $this->assertStringContainsString('namespace Modules\\Querylog\\Http\\Controllers', $contents);

    // Cleanup
    @unlink($dest);
    @rmdir(dirname($dest));
    @rmdir(app_path("modules/{$module}"));
  }
}
