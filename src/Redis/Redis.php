<?php

namespace Connfetti\Redis\Redis;

class Redis extends \Redis
{
    private $config = array('host' => 'localhost', 'port' => 6379, 'timeout' => 0, 'reserved' => null, 'retry_interval' => '', 'read_timeout' => '');

    public function __construct(array $config, string $password = '')
    {
        parent::__construct();
        if(isset($config['host'])) { $this->config['host'] = $config['host']; }
        if(isset($config['port'])) { $this->config['port'] = $config['port']; }
        if(isset($config['timeout'])) { $this->config['timeout'] = $config['timeout']; }
        if(isset($config['reserved'])) { $this->config['reserved'] = $config['reserved']; }
        if(isset($config['retry_interval'])) { $this->config['retry_interval'] = $config['read_timeout']; }
        if(isset($config['read_timeout'])) { $this->config['read_timeout'] = $config['read_timeout']; }

        $this->connect(
            $this->config['host'],
            $this->config['port'],
            $this->config['timeout'],
            $this->config['reserved'],
            $this->config['retry_interval'],
            $this->config['read_timeout']
            );

        if(strlen($password) > 0) {
            $this->auth($password);
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}
