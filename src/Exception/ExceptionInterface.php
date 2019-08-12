<?php
namespace Connfetti\Redis\Exception;


interface ExceptionInterface
{
    public function prettyOutputFormat();
    public function getError();
    public function getErrorTrace();
}
