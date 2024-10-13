# Larastack Supervisor

[![Packagist Version](https://img.shields.io/packagist/v/ariadata/larastack-supervisor)](https://packagist.org/packages/ariadata/larastack-supervisor)
[![GitHub License](https://img.shields.io/github/license/ariadata/larastack-supervisor)](https://github.com/ariadata/larastack-supervisor/blob/main/LICENSE)

Larastack Supervisor is a Laravel package that allows you to manage Supervisor processes directly via Artisan commands.
Whether you're starting, stopping, or checking the status of your processes, this package keeps your Supervisor
management simple and intuitive.

## Installation

You can install this package via Composer:

```bash
composer require ariadata/larastack-supervisor
```

## Configuration on `.env`

After installation, need to add these in your `.env` file:

```bash
SUPERVISOR_RPC_HOST=supervisor # or your supervisor host
SUPERVISOR_RPC_PORT=9001
SUPERVISOR_RPC_USER=user
SUPERVISOR_RPC_PASS=pass
```

## Usage

You can interact with Supervisor using either the `Facade` or the `helper function`.

### Using the `Facade`

Ensure you have added the alias in your config/app.php (this is automatically registered if you are using Laravel's
auto-discovery feature , laravel <= 7.x):

```php
# if laravel <= 7.x
'aliases' => [
    'LarastackSupervisor' => Ariadata\LarastackSupervisor\Facades\LarastackSupervisorFacade::class,
],
```

Examples:

```php
use LarastackSupervisor;

// Start a service
LarastackSupervisor::start('laravel-horizon');

// Stop a service
LarastackSupervisor::stop('laravel-horizon');

// Restart a service
LarastackSupervisor::restart('laravel-horizon');

// Get the status of all services
$statuses = LarastackSupervisor::status('all');

// List all processes
$processes = LarastackSupervisor::list();
```

### Using the Helper Function

You can also use the helper function `larastack_supervisor()` to interact with Supervisor:

```php
// Start all services
larastack_supervisor()->start('all');

// Stop a specific service
larastack_supervisor()->stop('laravel-horizon');

// Restart a specific service
larastack_supervisor()->restart('laravel-horizon');

// Check the status of all services
$statuses = larastack_supervisor()->status('all');

// List all processes
$processes = larastack_supervisor()->list();
```

## Available Artisan Commands

You can also manage Supervisor processes directly from the command line using Artisan.

### Command Signature

```bash
php artisan supervisor {action} {service?}
```

### Actions

- **list** - List all processes.
- **status [service]** - Show the status of a specific service or all services.
- **start [service]** - Start a specific service or all services.
- **stop [service]** - Stop a specific service or all services.
- **restart [service]** - Restart a specific service or all services.
- **Examples**
- Start all services:

```bash
php artisan supervisor start all
```

- Stop a specific service (e.g., laravel-horizon):

```bash
php artisan supervisor stop laravel-horizon
```

- Get the status of all services:

```bash
php artisan supervisor status all
```

- Restart a specific service:

```bash
php artisan supervisor restart laravel-horizon
```

## Process Statuses

The following statuses may be returned when querying the status of Supervisor-managed processes:

- STOPPED
- STARTING
- RUNNING
- BACKOFF
- STOPPING
- EXITED
- FATAL
- UNKNOWN

## License

This package is open-sourced software licensed under the `MIT` license.

### Key Points Covered:

- **Installation** via Composer.
- **Configuration** for customizing Supervisor's RPC settings.
- **Usage** examples with both the Facade and the helper function.
- **Artisan Commands** to control Supervisor processes from the command line.
- A list of **process statuses** that Supervisor can return.
- A structured and clean `README.md` file that provides clear instructions for installation, configuration, usage,
- and available commands for your package.
