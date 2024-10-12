# larastack-supervisor

## Installation

```bash
composer require ariadata/larastack-supervisor
```

## Usage

```bash
php artisan supervisor {start|stop|restart|status} {all|laravel-horizon}
```

```php
// via Facade :
// LarastackSupervisor::start('laravel-horizon');
// $status = LarastackSupervisor::status('all');
// $list = LarastackSupervisor::list();
// LarastackSupervisor::stop('laravel-horizon');
// LarastackSupervisor::restart('laravel-horizon');

// via helper function :
// larastack_supervisor()->start('laravel-horizon');
// $status = larastack_supervisor()->status('all');
// $list = larastack_supervisor()->list();
// larastack_supervisor()->stop('laravel-horizon');
// larastack_supervisor()->restart('laravel-horizon');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
