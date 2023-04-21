<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;
use Ds\Vector;

class TreeRelations
{
    private ?NodeInterface $parent = null;
    private ?NodeInterface $link = null;
    private Vector $childrenList;

    public function __construct()
    {
        $this->childrenList = new Vector();
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

    public function hasLink(): bool
    {
        return !is_null($this->link);
    }

    public function getLink(): ?NodeInterface
    {
        return $this->link;
    }

    public function setLink(?NodeInterface $node): self
    {
        $this->link = $node;
        return $this;
    }

    public function hasChildren(): bool
    {
        return !$this->childrenList->isEmpty();
    }

    public function getChildrenList(): Vector
    {
        return $this->childrenList;
    }

    public function addChild(NodeInterface $node): self
    {
        $this->childrenList->push($node);
        return $this;
    }

    public function removeChild(NodeInterface $node): self
    {
        $index = $this
            ->childrenList
            ->map(fn(NodeInterface $childNode) => $childNode->getUid())
            ->find($node->getUid());
        if ($index !== false) {
            $this->childrenList->remove($index);
        }
        return $this;
    }

    public function clearChildren(): self
    {
        $this->childrenList->clear();
        return $this;
    }
}
