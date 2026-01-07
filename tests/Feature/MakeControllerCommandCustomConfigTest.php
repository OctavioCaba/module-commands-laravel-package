<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeControllerCommandCustomConfigTest extends TestCase
{
  public function test_custom_module_namespace_config_is_used()
  {
    $name = 'CustomConfigController';
    $module = 'querylog';

    $dest = app_path("modules/{$module}/Http/Controllers/{$name}.php");

    // Ensure clean state
    if (file_exists($dest)) {
      @unlink($dest);
    }

    // Set custom config
    $this->app['config']->set('module-commands.module_namespace', 'MyCompany\\Modules');

    // Run the artisan command
    $this->artisan('make:module-controller', [
      'name' => $name,
      'module' => $module,
      '--force' => true,
    ])->assertExitCode(0);

    $this->assertFileExists($dest);
    $contents = file_get_contents($dest);
    $this->assertStringContainsString('namespace MyCompany\\Modules\\Querylog\\Http\\Controllers', $contents);

    // Cleanup
    @unlink($dest);
    @rmdir(dirname($dest));
    @rmdir(app_path("modules/{$module}"));
  }
}
