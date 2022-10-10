<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends AbstractController
{
    // An action that needs authentication
    public function index()
    {
   
        return new Response("listo");
    }
}