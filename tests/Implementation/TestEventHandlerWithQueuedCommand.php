<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:56 PM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractEvent;
use Infra\AbstractEventListener;

class TestEventHandlerWithQueuedCommand extends AbstractEventListener
{
    public $count;

    /**
     * @param AbstractEvent $event
     * @return void
     */
    public function receiveEvent(AbstractEvent $event)
    {
        $this->count++;

        $this->addCommand(new TestCommand(rand(1, 100)));
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }


}