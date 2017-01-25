<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:25 PM
 */

namespace Infra;


use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class AbstractAction
{
    /** @var CommandBus  */
    protected $commandBus;

    /** @var EventBus  */
    protected $eventBus;

    /**
     * AbstractAction constructor.
     *
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->commandBus = $bus;
        $this->eventBus = $bus->getEventBus();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return ResponseInterface
     */
    abstract public function __invoke(Request $request, Response $response, array $args = []);
}