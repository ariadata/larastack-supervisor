<?php

namespace Ariadata\LarastackSupervisor;

use Supervisor\Supervisor;
use fXmlRpc\Client;
use fXmlRpc\Transport\PsrTransport;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Client as GuzzleClient;

class LarastackSupervisor
{
    protected static function supervisorClient(): Supervisor
    {
        $client = new Client(
            'http://' . config('larastack-supervisor.auth.rpc.host') . ':' . config('larastack-supervisor.auth.rpc.port') . '/RPC2',
            new PsrTransport(
                new HttpFactory(),
                new GuzzleClient([
                    'auth' => [
                        config('larastack-supervisor.auth.rpc.user'),
                        config('larastack-supervisor.auth.rpc.pass'),
                    ],
                ])
            )
        );
        return new Supervisor($client);
    }

    public static function list(): array
    {
        $res = self::supervisorClient()->getAllProcessInfo();
        $processes = [];
        foreach($res as $process) {
            $processes[] = $process['name'];
        }
        return $processes;
    }
    public static function start(string $service = null,bool $wait = true): bool
    {
        if ($service == 'all' || $service == null) {
            $allWithStatuses = self::status();
            foreach($allWithStatuses as $process) {
                if($process['status'] != 'RUNNING') {
                    try {
                        self::supervisorClient()->startProcess($process['name'], $wait);
                    } catch (\Exception $e) {
                        return false;
                    }
                }
            }
            return true;
        }
        try {
            $status = self::status($service);
            if($status['status'] != 'RUNNING') {
                return self::supervisorClient()->startProcess($service, $wait);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function stop(string $service = null,bool $wait = true): bool
    {
        if ($service == 'all' || $service == null) {
            $allWithStatuses = self::status();
            foreach($allWithStatuses as $process) {
                if($process['status'] == 'RUNNING') {
                    try {
                        self::supervisorClient()->stopProcess($process['name'], $wait);
                    } catch (\Exception $e) {
                        return false;
                    }
                }
            }
            return true;
        }
        try {
            $status = self::status($service);
            if($status['status'] == 'RUNNING') {
                return self::supervisorClient()->stopProcess($service, $wait);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function restart(string $service = null,bool $wait = true): bool
    {
        try {
            self::stop($service, $wait);
            return self::start($service, $wait);
        } catch (\Exception $e) {
            return false;
        }

    }

    public static function status(string $service = null): array
    {
        if($service == 'all' || $service == null) {
            $res = self::supervisorClient()->getAllProcessInfo();
            $processes = [];
            foreach($res as $process) {
                $processes[] = ['name' => $process['name'], 'status' => $process['statename']];
            }
            return $processes;
        }
        $res = self::supervisorClient()->getProcessInfo($service);
        return ['name' => $res['name'], 'status' => $res['statename']];
    }
}
