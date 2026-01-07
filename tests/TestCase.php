<?php

namespace Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
  /**
   * Register package service providers for the tests.
   *
   * @param \Illuminate\Foundation\Application $app
   * @return array
   */
  protected function getPackageProviders($app)
  {
    return [
      \OctavioCaba\ModuleCommandsLaravelPackage\ModuleCommandsLaravelPackageServiceProvider::class,
    ];
  }
}
