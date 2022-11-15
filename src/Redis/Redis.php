<?php

namespace Connfetti\Redis\Redis;

use Connfetti\Redis\Exception\DriverException;
use Connfetti\Redis\Model\HashModel;

class Redis extends \Redis
{
    public static $VERSION = '0.2.2';

    private $config = array('host' => 'localhost', 'port' => 6379, 'timeout' => 0, 'reserved' => null, 'retry_interval' => 0, 'read_timeout' => 0.0);

    public function __construct(array $config, string $password = '')
    {
        parent::__construct();
        if(isset($config['host'])) { $this->config['host'] = $config['host']; }
        if(isset($config['port'])) { $this->config['port'] = $config['port']; }
        if(isset($config['timeout'])) { $this->config['timeout'] = $config['timeout']; }
        if(isset($config['reserved'])) { $this->config['reserved'] = $config['reserved']; }
        if(isset($config['retry_interval'])) { $this->config['retry_interval'] = $config['read_timeout']; }
        if(isset($config['read_timeout'])) { $this->config['read_timeout'] = $config['read_timeout']; }

        try {
            @$this->connect(
                $this->config['host'],
                $this->config['port'],
                $this->config['timeout'],
                $this->config['reserved'],
                $this->config['retry_interval'],
                $this->config['read_timeout']
            );
        } catch(\RedisException $e) {
            throw new DriverException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        if(strlen($password) > 0) {
            $this->auth($password);
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    public function setHashByModel(HashModel $hashmodel, bool $resethash = true)
    {
        $retstate_ar = array();
        $data = $hashmodel->getAsArray();
        if($resethash) {
            $this->del($hashmodel->getHashname());
        }
        foreach($data as $hkey => $hvalue) {
            $retstate_ar[] = $this->hSet($hashmodel->getHashname(), $hkey, $hvalue);
        }
        return $retstate_ar;
    }

    public function getHashByName(string $hashname)
    {
        $hashmodel = new HashModel($hashname);
        $hashmodel->populateByArray($this->hGetAll($hashname));
        return $hashmodel;
    }
}
