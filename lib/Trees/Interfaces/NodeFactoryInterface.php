<?php declare (strict_types=1);

namespace Trees\Interfaces;

use Trees\Node;

interface NodeFactoryInterface
{
    public function create(string $itemName, ?string $parent, ?string $relation): NodeInterface;
}
