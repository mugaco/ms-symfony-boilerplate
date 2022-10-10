<?php
namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response as Res;

class Response
{
    public function json(array $array, $status, $headers = [])
    {

        return new Res(
            json_encode($array),
            $status,
            array_merge($headers, ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
}
