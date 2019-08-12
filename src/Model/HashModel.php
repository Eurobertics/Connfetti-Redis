<?php
namespace Connfetti\Redis\Model;

class HashModel
{
    private $hashname;
    private $hashdata = array();
    private $hashcount = 0;

    public function __construct(string $hashname = '')
    {
        if(strlen($hashname) > 0) {
            $this->hashname = $hashname;
        }
    }

    public function setHashname(string $hasname)
    {
        if(strlen($this->hashname) > 0) {
            return false;
        }
        $this->hashname = $hasname;
        return true;
    }

    public function getHashname()
    {
        return $this->hashname;
    }

    public function __set($name, $value)
    {
        if(is_string($name)) {
            $this->hashdata[$name] = $value;
            return true;
        }
        return false;
    }

    public function __get($name)
    {
        if(key_exists($name, $this->hashdata)) {
            return $this->hashdata[$name];
        }
        return null;
    }

    public function __isset($name)
    {
        return (isset($this->hashdata[$name]) ? true : false);
    }

    public function __unset($name)
    {
        if(key_exists($name, $this->hashdata)) {
            unset($this->hashdata[$name]);
            $this->hashcount--;
        }
    }

    public function populateByArray(array $data)
    {
        foreach($data as $hkey => $hval) {
            $this->hashdata[$hkey] = $hval;
            $this->hashcount++;
        }
    }

    public function getAsArray()
    {
        return $this->hashdata;
    }

    public function removeAllData()
    {
        $this->hashdata = array();
    }

    public function count()
    {
        return $this->hashcount;
    }
}
