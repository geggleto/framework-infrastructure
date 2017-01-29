<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-29
 * Time: 12:30 AM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractCommand;
use Infra\AbstractCommandHandler;
use Infra\EventDipsatcher;

class FunctionalTestCommandHandler extends AbstractCommandHandler
{
    protected $count;

    protected $dispatcher;

    public function __construct(EventDipsatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->count = 0;
    }

    public function handle(AbstractCommand $command)
    {
        if ($command instanceof FunctionTestCommand) {
            $this->count++;

            if ($this->count == 1) {
                $this->dispatcher->raise(new TestEvent());
            }
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