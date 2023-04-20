<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;
use Ds\Map;
use Ds\Vector;

class Tree
{
    private Map $relations;

    public function __construct()
    {
        $this->relations = new Map();
    }

    public function hasParent(NodeInterface $node): bool
    {
        return $this->getRelations($node)->hasParent();
    }

    public function getParent(NodeInterface $node): ?NodeInterface
    {
        return $this->getRelations($node)->getParent(); 
    }

    public function setParent(NodeInterface $node, ?NodeInterface $parentNode): self
    {
        $this->detachParent($node)->attachParent($node, $parentNode);
        return $this;
    }

    public function hasChildren(?NodeInterface $node): bool
    {
        return $this->getRelations($node)->hasChildren();
    }

    public function getChildren(?NodeInterface $node): Vector
    {
        return $this->getRelations($node)->getChildren()->copy();
    }

    public function getChildrenCount(?NodeInterface $node): int
    {
        return count($this->getRelations($node)->getChildren());
    }

    public function forget(NodeInterface $node): self
    {
        $this->detachParent($node)
            ->detachChildren($node)
            ->removeRelations($node);
        return $this;
    }

    private function detachParent(NodeInterface $node): self
    {
        $this->getRelations($this->getRelations($node)->getParent())->removeChild($node);
        $this->getRelations($node)->setParent(null);
        return $this;
    }

    private function detachChildren(NodeInterface $node): self
    {
        foreach ($this->getRelations($node)->getChildren() as $childNode) {
            $this->getRelations($childNode)->setParent(null);
        }
        $this->getRelations($node)->clearChildren();
        return $this;
    }

    private function attachParent(NodeInterface $node, ?NodeInterface $parentNode): self
    {
        $this->getRelations($node)->setParent($parentNode);
        $this->getRelations($parentNode)->addChild($node);
        return $this;
    }

    private function getRelations(?NodeInterface $node): TreeRelations
    {
        if (!$this->relations->hasKey($node?->getUid())) {
            $this->relations->put($node?->getUid(), new TreeRelations()); 
        }
        return $this->relations->get($node?->getUid());
    }

    private function removeRelations(?NodeInterface $node)
    {
        if ($this->relations->hasKey($node?->getUid())) {
            $this->relations->remove($node?->getUid()); 
        }
    }
}
