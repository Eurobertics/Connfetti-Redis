<?php
namespace Connfetti\Redis\Exception;


interface ExcpetionInterface
{
    public function prettyOutputFormat();
    public function getError();
    public function getErrorTrace();
}
