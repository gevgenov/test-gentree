<?php declare (strict_types=1);

namespace Trees\Factories;

use Trees\Factories\Interfaces\NodeFactoryInterface;
use Trees\Node;

class NodeFactory implements NodeFactoryInterface
{
    public function create(string $itemName, ?string $parent, ?string $relation): Node
    {
        return new Node($itemName, $parent, $relation);
    }
}
