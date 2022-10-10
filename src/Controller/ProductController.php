<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Controller\TokenAuthenticatedController;

class ProductController extends AbstractController implements TokenAuthenticatedController
{
    public function index()
    {
        return new Response('Lo que sería una lista de productos');
    }
    public function createAction(DocumentManager $dm)
    {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');

        $dm->persist($product);
        $dm->flush();
     
        return new Response('Created product id ' . $product->getId());
    }
}
