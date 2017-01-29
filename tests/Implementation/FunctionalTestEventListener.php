<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-29
 * Time: 12:32 AM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractEvent;
use Infra\AbstractEventListener;
use Infra\CommandBus;

class FunctionalTestEventListener extends AbstractEventListener
{
    /** @var CommandBus  */
    protected $bus;

    protected $count;

    public function __construct(CommandBus $bus)
    {
        $this->count = 0;
        $this->bus = $bus;
    }

    public function receiveEvent(AbstractEvent $event)
    {
        if ($event instanceof TestEvent) {
            $this->count = 1;
            $this->bus->handle(new FunctionTestCommand());
        }
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }


}