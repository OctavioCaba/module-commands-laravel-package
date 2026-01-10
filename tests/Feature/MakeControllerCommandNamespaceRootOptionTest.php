<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeControllerCommandNamespaceRootOptionTest extends TestCase
{
  public function test_namespace_root_option_overrides_config()
  {
    $name = 'OptionController';
    $module = 'querylog';

    $dest = app_path("modules/{$module}/src/Http/Controllers/{$name}.php");

    // Ensure clean state
    if (file_exists($dest)) {
      @unlink($dest);
    }

    // Run the artisan command with --namespace-root
    $this->artisan('make:module-controller', [
      'name' => $name,
      'module' => $module,
      '--namespace-root' => 'CustomRoot',
      '--force' => true,
    ])->assertExitCode(0);

    $this->assertFileExists($dest);
    $contents = file_get_contents($dest);
    $this->assertStringContainsString('namespace CustomRoot\\Querylog\\Http\\Controllers', $contents);

    // Cleanup
    @unlink($dest);
    @rmdir(dirname($dest));
    @rmdir(app_path("modules/{$module}"));
  }
}
