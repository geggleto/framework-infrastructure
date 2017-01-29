<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:24 PM
 */

namespace Infra;


use Interop\Container\ContainerInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * @var array
     */
    protected $handlers;

    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * CommandBus constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $command
     * @param $class
     */
    public function addHandler($command, $class) {
        if (!class_exists($command)) {
            throw new \InvalidArgumentException("Class $command does not exist");
        }

        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Class $class does not exist");
        }

        $this->handlers[$command] = $class;
    }

    /**
     * @param AbstractCommand $command
     * @return bool
     */
    public function handle(AbstractCommand $command) {
        /** @var $handler string */
        if ($handlerEntry = $this->handlers[get_class($command)]) {

            /** @var $handler AbstractCommandHandler */
            $handler = $this->container->get($handlerEntry);

            $result = $handler->handle($command);

            return $result;
        }
        return false;
    }
}