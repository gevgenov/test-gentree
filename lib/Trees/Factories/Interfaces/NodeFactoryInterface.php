<?php declare (strict_types=1);

namespace Trees\Factories\Interfaces;

use Trees\Interfaces\NodeInterface;

interface NodeFactoryInterface
{
    public function create(string $itemName, ?string $parent, ?string $relation): NodeInterface;
}
