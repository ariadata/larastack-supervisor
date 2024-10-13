<?php

namespace Ariadata\LarastackSupervisor\Console\Commands;

use Illuminate\Console\Command;
use Ariadata\LarastackSupervisor\LarastackSupervisor;

class SupervisorCommand extends Command
{
    // Signature to handle various subcommands and arguments
    protected $signature = 'supervisor {action?} {service?}';
    protected $description = 'Manage Larastack Supervisor processes';

    public function handle():void
    {
        // Retrieve the action and service arguments
        $action = $this->argument('action');
        $service = $this->argument('service') ?? 'all';

        // If no action is provided or help is requested, show help
        if (!$action || $action === 'help') {
            $this->showHelp();
        }

        // Handle the various actions
        switch ($action) {
            case 'list':
                $this->listProcesses();
                return;

            case 'status':
                $this->status($service);
                return;

            case 'start':
                $this->start($service);
                return;

            case 'stop':
                $this->stop($service);
                return;

            case 'restart':
                $this->restart($service);
                return;

            default:
                // If the action is unknown, show the help message
                $this->error("Unknown action: $action");
                $this->showHelp();
                return;
        }
    }

    /**
     * Show help information if no arguments are provided or 'help' is requested.
     */
    protected function showHelp():void
    {
        $this->info('Usage:');
        $this->line('  php artisan supervisor list');
        $this->line('  php artisan supervisor status [all|service-name]');
        $this->line('  php artisan supervisor start [all|service-name]');
        $this->line('  php artisan supervisor stop [all|service-name]');
        $this->line('  php artisan supervisor restart [all|service-name]');
        $this->line('  php artisan supervisor help');
    }

    /**
     * List all processes managed by Supervisor.
     */
    protected function listProcesses():void
    {
        $processes = LarastackSupervisor::list();
        if (empty($processes)) {
            $this->info('No processes found.');
        } else {
            foreach ($processes as $process) {
                $this->line($process);
            }
        }
    }

    /**
     * Show the status of a specific service or all services.
     */
    protected function status(string $service): void
    {
        $statuses = LarastackSupervisor::status($service);
        if (isset($statuses['name'])) {
            // Single service status
            $this->info("Service: {$statuses['name']} - Status: {$statuses['status']}");
        } else {
            // Multiple services status
            foreach ($statuses as $process) {
                $this->info("Service: {$process['name']} - Status: {$process['status']}");
            }
        }
    }

    /**
     * Start a specific service or all services.
     */
    protected function start(string $service): void
    {
        if (LarastackSupervisor::start($service)) {
            $this->info("Supervisor process {$service} has been started.");
        } else {
            $this->error("Failed to start Supervisor process {$service}.");
        }
    }

    /**
     * Stop a specific service or all services.
     */
    protected function stop(string $service): void
    {
        if (LarastackSupervisor::stop($service)) {
            $this->info("Supervisor process {$service} has been stopped.");
        } else {
            $this->error("Failed to stop Supervisor process {$service}.");
        }
    }

    /**
     * Restart a specific service or all services.
     */
    protected function restart(string $service): void
    {
        if (LarastackSupervisor::restart($service)) {
            $this->info("Supervisor process {$service} has been restarted.");
        } else {
            $this->error("Failed to restart Supervisor process {$service}.");
        }
    }
}
