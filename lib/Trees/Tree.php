<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;
use Ds\Map;
use Ds\Vector;

class Tree
{
    private Map $relationMap;

    public function __construct()
    {
        $this->relationMap = new Map();
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

    public function setLink(NodeInterface $node, ?NodeInterface $targetNode): self
    {
        $this->getRelations($node)->setLink($targetNode);
        return $this;
    }

    public function hasChildren(?NodeInterface $node = null): bool
    {
        return $this->getChildrenRelations($node)->hasChildren();
    }

    public function getChildrenList(?NodeInterface $node = null): Vector
    {
        return $this->getChildrenRelations($node)->getChildrenList()->copy();
    }

    public function getChildrenCount(?NodeInterface $node = null): int
    {
        return count($this->getChildrenRelations($node)->getChildren());
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
        if ($this->getRelations($node)->hasLink()) {
            return $this;
        }
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

    private function getChildrenRelations(?NodeInterface $node): TreeRelations
    {
        $relations = $this->getRelations($node);
        return $relations->hasLink() ? $this->getRelations($relations->getLink()) : $relations;
    }
    
    private function getRelations(?NodeInterface $node): TreeRelations
    {
        if (!$this->relationMap->hasKey($node?->getUid())) {
            $this->relationMap->put($node?->getUid(), new TreeRelations()); 
        }
        return $this->relationMap->get($node?->getUid());
    }

    private function removeRelations(?NodeInterface $node)
    {
        if ($this->relationMap->hasKey($node?->getUid())) {
            $this->relationMap->remove($node?->getUid()); 
        }
    }
}
