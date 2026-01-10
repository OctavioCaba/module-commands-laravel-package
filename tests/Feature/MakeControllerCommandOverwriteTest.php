<?php

namespace Tests\Feature;

use Tests\TestCase;

class MakeControllerCommandOverwriteTest extends TestCase
{
  public function test_decline_overwrite_keeps_existing_file()
  {
    $name = 'ExistingController';
    $module = 'querylog';

    $dest = app_path("Modules/{$module}/src/Http/Controllers/{$name}.php");

    // Ensure directory exists
    $dir = dirname($dest);
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    // Create an initial file with unique content
    $original = "// ORIGINAL CONTENT " . uniqid();
    file_put_contents($dest, $original);

    // Run the artisan command and simulate answering 'no' to overwrite
    $this->artisan('make:module-controller', [
      'name' => $name,
      'module' => $module,
    ])->expectsConfirmation("{$dest} already exists. Overwrite?", 'no')
      ->assertExitCode(0);

    // File should remain unchanged
    $this->assertFileExists($dest);
    $this->assertSame($original, file_get_contents($dest));

    // Cleanup
    @unlink($dest);
    @rmdir($dir);
    @rmdir(app_path("Modules/{$module}"));
  }

  public function test_force_overwrite_replaces_existing_file()
  {
    $name = 'ExistingController';
    $module = 'querylog';

    $dest = app_path("modules/{$module}/src/Http/Controllers/{$name}.php");

    // Ensure directory exists
    $dir = dirname($dest);
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }

    // Create an initial file with unique content
    $original = "// ORIGINAL CONTENT " . uniqid();
    file_put_contents($dest, $original);

    // Run the artisan command with --force to overwrite
    $this->artisan('make:module-controller', [
      'name' => $name,
      'module' => $module,
      '--force' => true,
    ])->assertExitCode(0);

    // File should exist and be different from original
    $this->assertFileExists($dest);
    $contents = file_get_contents($dest);
    $this->assertNotSame($original, $contents);

    // Check that stub placeholders were replaced (namespace and class)
    $this->assertStringContainsString('namespace Modules\\Querylog\\Http\\Controllers', $contents);
    $this->assertStringContainsString('class ' . $name, $contents);

    // Cleanup
    @unlink($dest);
    @rmdir($dir);
    @rmdir(app_path("modules/{$module}"));
  }
}
