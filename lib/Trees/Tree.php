<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;

class Tree
{
    public function hasParentNode(NodeInterface $node): bool
    {
        return false; 
    }

    public function getParentNode(NodeInterface $node): ?NodeInterface
    {
        return null; 
    }

    public function setParentNode(NodeInterface $node, ?NodeInterface $parentNode = null): self
    {
        return $this; 
    }

    public function hasChildNodes(?NodeInterface $node = null): bool
    {
        return false; 
    }

    public function getChildNodes(?NodeInterface $node = null): iterable
    {
        return [];    
    }
}
