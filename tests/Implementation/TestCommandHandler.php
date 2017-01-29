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

class TestCommandHandler extends AbstractCommandHandler
{
    protected $count;

    public function handle(AbstractCommand $command)
    {
        if ($command instanceof TestCommand) {
            $this->count = $command->getSecret();
        } else {
            die();
        }
    }

    public function getCount() {
        return $this->count;
    }

}