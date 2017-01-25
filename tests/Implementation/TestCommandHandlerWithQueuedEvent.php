<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:32 PM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractCommand;
use Infra\AbstractCommandHandler;

class TestCommandHandlerWithQueuedEvent extends AbstractCommandHandler
{
    protected static $count;

    public function handle(AbstractCommand $command)
    {
        self::$count++;

        if (self::$count == 1) {
            $this->raise(new TestEvent());
        }

    }

    public function getCount() {
        return self::$count;
    }

}