<?php declare (strict_types=1);

namespace Trees;

use JsonSerializable;
use Trees\Interfaces\NodeInterface;

class Tree implements JsonSerializable
{
    public function hasParentNode(NodeInterface $node): bool
    {
    }

    public function getParentNode(NodeInterface $node): ?NodeInterface
    {
    
    }

    public function setParentNode(NodeInterface $node, ?NodeInterface $parentNode = null): self
    {
    
    }

    public function hasChildNodes(?NodeInterface $node = null): bool
    {
    
    }

    public function getChildNodes(?NodeInterface $node = null): iterable
    {
    
    }
}
