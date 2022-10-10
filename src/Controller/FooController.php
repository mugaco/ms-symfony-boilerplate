<?php

namespace App\Controller;

use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FooController extends AbstractController implements TokenAuthenticatedController
// class FooController extends AbstractController
{
    // An action that needs authentication
    public function bar(Request $request)
    {
        return response()->json([
            "res" => $_ENV['MS_SCOPE'],
            "user"=>$request->get("user")
        ], 200);
    }
}
