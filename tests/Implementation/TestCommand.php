<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:28 PM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractCommand;

class TestCommand extends AbstractCommand
{
    protected $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function getSecret() {
        return $this->secret;
    }

    public function getName()
    {
        return self::class;
    }
}