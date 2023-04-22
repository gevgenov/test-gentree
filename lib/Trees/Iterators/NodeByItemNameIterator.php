<?php declare (strict_types=1);

namespace Trees\Iterators;

use IteratorAggregate;
use Generator;
use Trees\Interfaces\NodeInterface;

/**
 * @implements IteratorAggregate<mixed, NodeInterface>
 */
class NodeByItemNameIterator implements IteratorAggregate
{
    public function __construct(private iterable $nodeList) {}

    public function getIterator(): Generator
    {
        foreach ($this->nodeList as $node) {
            yield $node->getItemName() => $node;
        }
    }
}
