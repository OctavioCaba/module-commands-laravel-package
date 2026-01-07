# ModuleCommandsLaravelPackage

Un pequeño paquete para Laravel que agrega comandos Artisan para gestionar una estructura modular dentro de paquetes y aplicaciones Laravel. Simplifica la creación, listado, habilitación/deshabilitación, migraciones y el scaffolding de componentes de módulos (controladores, modelos, migraciones, factories, seeders, rutas y vistas).

## Features

- Crear el scaffold de un nuevo módulo
- Listar módulos registrados
- Habilitar / deshabilitar módulos
- Generar controladores, modelos, requests y resources dentro de un módulo
- Ejecutar migraciones, seeders y rollbacks específicos de un módulo
- Publicar assets y configuraciones del módulo
- Integración con el autoloading y los service providers de Laravel

## Instalación

1. Requerir el paquete vía `composer`:
```bash
composer require octaviocaba/module-commands-laravel-package
```

2. Registrar el service provider en `config/app.php`:
```php
'providers' => [
  OctavioCaba\ModuleCommands\ModuleCommandsServiceProvider::class,
];
```

3. Publicar la configuración y los `stubs` (opcional):
```bash
php artisan vendor:publish --provider="OctavioCaba\ModuleCommands\ModuleCommandsServiceProvider" --tag="config"
php artisan vendor:publish --provider="OctavioCaba\ModuleCommands\ModuleCommandsServiceProvider" --tag="stubs"
```

## Configuración

Después de publicar, edita `config/module-commands.php` para ajustar:
- directorio de módulos (por defecto: `modules`)
- namespace raíz para las clases generadas
- stubs por defecto y organización de archivos
- almacenamiento para el seguimiento de módulos habilitados (`filesystem`, `config` o base de datos)

## Comandos Disponibles

<!-- - Create module scaffold
```bash
php artisan module:make {name}
```

- List modules
```bash
php artisan module:list
```

- Enable a module
```bash
php artisan module:enable {name}
```

- Disable a module
```bash
php artisan module:disable {name}
``` -->

- Genera `controllers` para el módulo
```bash
php artisan module:make:controller {module} {name} [--resource] [--api]
```

<!-- - Generate model inside a module
```bash
php artisan module:make:model {module} {name} [-m|--migration]
```

- Create migration for a module
```bash
php artisan module:make:migration {module} {name}
```

- Run module migrations
```bash
php artisan module:migrate {module}
```

- Rollback module migrations
```bash
php artisan module:migrate:rollback {module}
```

- Seed a module
```bash
php artisan module:db:seed {module} [--class=SeederClass]
```

- Publish module assets
```bash
php artisan module:publish {module}
``` -->

<!-- (Use `php artisan help {command}` for per-command options and examples.) -->

## Estructura de directorios y ficheros

Contenido típico de un módulo:
```
modules/
└── Blog/
  ├── src/
  │   ├── Http/
  │   │   ├── Controllers/
  │   ├── Models/
  │   ├── Database/
  │   │   ├── Migrations/
  │   │   └── Seeders/
  │   ├── Providers/
  │   └── routes.php
  ├── resources/
  │   └── views/
  └── composer.json
```

<!-- ## Best practices

- Create a service provider for each module to register bindings, routes and views.
- Use module namespace configuration to keep autoloading consistent.
- Keep migrations and seeders inside the module's Database folder for portability. -->

## Testing

Correr tests:
```bash
composer test
# or
vendor/bin/phpunit
```

<!-- ## Contributing

1. Fork the repository
2. Create a feature branch
3. Send a PR with tests and descriptive changelog

Thanks for helping improve the package. -->

## Licnencia

MIT — consulta el fichero LICENSE para más detalle.
