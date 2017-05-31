<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test\Resources;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Invokable;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Route;

/**
 * @Route(path="/path", methods={"GET", "POST"}, name="route-name")
 */
final class RouteWithAnnotation
{
    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {

    }
}
