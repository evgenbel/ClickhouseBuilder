<?php

namespace Evgenbel\ClickhouseBuilder;

use PHPUnit\Framework\TestCase;
use Evgenbel\ClickhouseBuilder\Query\Identifier;

class IdentifierTest extends TestCase
{
    public function testToString()
    {
        $identifier = new Identifier('column');

        $this->assertEquals('column', (string) $identifier);
    }
}
