<?php
// src/EventSubscriber/TokenSubscriber.php
namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use App\Helpers\Response as HelpersResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenSubscriber implements EventSubscriberInterface
{
    // private $tokens;

    public function __construct()
    {
        // $this->tokens = [];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedController) {
            try {
                $request = $event->getRequest();
                $publicKey = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/../public.key");
                $token = $request->headers->get('Authorization');
                $tt = explode(" ", $token);
                $decoded = JWT::decode($tt[1], new Key($publicKey, 'RS256'));
                $user = $decoded->data;
                $request->attributes->set('user', $user);
                // $user->scopes = ['product'];
                if (!isset($user->scopes)) {
                    throw new \Exception("error scope", 1);
                }
                if (is_array($user->scopes)) {
                    if (!in_array($_ENV['MS_SCOPE'], $user->scopes)) {
                        throw new \Exception("error Scope", 1);
                    }
                } else {
               //     dd($_ENV["MS_SCOPE"]);
                    if ($_ENV['MS_SCOPE'] != $user->scopes) {
                        throw new \Exception("error Scope", 1);
                    }
                }
                //throw new \Exception("Error Processing Request", 1);
                // return new Response(json_encode($user));
            } catch (\Throwable $th) {
                $event->setController(function () use ($th) {
                    $message = "unauthorized";
                    $status = 401;
                    if($th->getMessage()=='error scope'){
                        $message = "forbidden";
                        $status = 403;
                    }
                    return new Response(
                        json_encode(['message' => $message]),
                        $status,
                        ['Content-Type' => 'application/json;charset=UTF-8']
                    );
                });
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
