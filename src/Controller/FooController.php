<?php
namespace App\Controller;

use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooController extends AbstractController implements TokenAuthenticatedController
{
    // An action that needs authentication
    public function bar()
    {
        // ...
    }
}