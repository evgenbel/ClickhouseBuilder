<?php

namespace Evgenbel\ClickhouseBuilder\Query\Traits;

use Evgenbel\ClickhouseBuilder\Exceptions\GrammarException;
use Evgenbel\ClickhouseBuilder\Query\BaseBuilder;
use Evgenbel\ClickhouseBuilder\Query\From;

trait FromComponentCompiler
{
    /**
     * Compiles format statement.
     *
     * @param BaseBuilder $builder
     * @param             $from
     *
     * @return string
     */
    public function compileFromComponent(BaseBuilder $builder, From $from) : string
    {
        $this->verifyFrom($from);

        $table = $from->getTable();
        $alias = $from->getAlias();
        $final = $from->getFinal();

        $fromSection = '';
        $fromSection .= "FROM {$this->wrap($table)}";

        if (!is_null($alias)) {
            $fromSection .= " AS {$this->wrap($alias)}";
        }

        if (!is_null($final)) {
            $fromSection .= ' FINAL';
        }

        return $fromSection;
    }

    /**
     * Verifies from.
     *
     * @param From $from
     *
     * @throws GrammarException
     */
    private function verifyFrom(From $from)
    {
        if (is_null($from->getTable())) {
            throw GrammarException::wrongFrom($from);
        }
    }
}
