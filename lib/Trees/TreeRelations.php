<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;
use Ds\Vector;

class TreeRelations
{
    private ?NodeInterface $parent = null;
    private Vector $children;

    public function __construct()
    {
        $this->children = new Vector();
    }

    public function hasParent(): bool
    {
        return !is_null($this->parent);
    }

    public function getParent(): ?NodeInterface
    {
        return $this->parent;
    }

    public function setParent(?NodeInterface $node): self
    {
        $this->parent = $node;
        return $this;
    }

    public function hasChildren(): bool
    {
        return !$this->children->isEmpty();
    }

    public function getChildren(): Vector
    {
        return $this->children;
    }

    public function addChild(NodeInterface $node): self
    {
        $this->children->push($node);
        return $this;
    }

    public function removeChild(NodeInterface $node): self
    {
        $index = $this
            ->children
            ->map(fn(NodeInterface $childNode) => $childNode->getUid())
            ->find($node->getUid());
        if ($index !== false) {
            $this->children->remove($index);
        }
        return $this;
    }

    public function clearChildren(): self
    {
        $this->children->clear();
        return $this;
    }
}
