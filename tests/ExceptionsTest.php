<?php

namespace Evgenbel\ClickhouseBuilder;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Tinderbox\Clickhouse\Client;
use Evgenbel\ClickhouseBuilder\Exceptions\BuilderException;
use Evgenbel\ClickhouseBuilder\Exceptions\GrammarException;
use Evgenbel\ClickhouseBuilder\Exceptions\NotSupportedException;
use Evgenbel\ClickhouseBuilder\Query\Builder;
use Evgenbel\ClickhouseBuilder\Query\From;
use Evgenbel\ClickhouseBuilder\Query\JoinClause;

class ExceptionsTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function getBuilder() : Builder
    {
        return new Builder(m::mock(Client::class));
    }

    public function testBuilderException()
    {
        $e = BuilderException::cannotDetermineAliasForColumn();
        $this->assertInstanceOf(BuilderException::class, $e);
    }

    public function testGrammarException()
    {
        $e = GrammarException::missedTableForInsert();
        $this->assertInstanceOf(GrammarException::class, $e);

        $from = new From($this->getBuilder());

        $e = GrammarException::wrongFrom($from);
        $this->assertInstanceOf(GrammarException::class, $e);

        $join = new JoinClause($this->getBuilder());

        $e = GrammarException::wrongJoin($join);
        $this->assertInstanceOf(GrammarException::class, $e);
    }

    public function testNotSupportedException()
    {
        $e = NotSupportedException::transactions();
        $this->assertInstanceOf(NotSupportedException::class, $e);

        $e = NotSupportedException::updateAndDelete();
        $this->assertInstanceOf(NotSupportedException::class, $e);
    }
}
