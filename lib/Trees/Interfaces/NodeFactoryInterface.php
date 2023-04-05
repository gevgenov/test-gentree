<?php declare (strict_types=1);

namespace Trees\Interfaces;

use Trees\Node;

interface NodeFactoryInterface
{
    public function __invoke(array $record): Node
}
