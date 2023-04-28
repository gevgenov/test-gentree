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
        return $this->getRelations($node)->hasChildren();
    }

    public function getChildrenList(?NodeInterface $node = null): Vector
    {
        return $this->getRelations($node)->getChildrenList()->copy();
    }

    public function getChildrenCount(?NodeInterface $node = null): int
    {
        return count($this->getRelations($node)->getChildrenList());
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
        $this->getOwnRelations($this->getOwnRelations($node)->getParent())->removeChild($node);
        $this->getOwnRelations($node)->setParent(null);
        return $this;
    }

    private function detachChildren(NodeInterface $node): self
    {
        foreach ($this->getOwnRelations($node)->getChildrenList() as $childNode) {
            $this->getOwnRelations($childNode)->setParent(null);
        }
        $this->getOwnRelations($node)->clearChildren();
        return $this;
    }

    private function attachParent(NodeInterface $node, ?NodeInterface $parentNode): self
    {
        $this->getOwnRelations($node)->setParent($parentNode);
        $this->getOwnRelations($parentNode)->addChild($node);
        return $this;
    }

    private function getRelations(?NodeInterface $node): TreeRelations
    {
        $ownRelations = $this->getOwnRelations($node);
        return $ownRelations->hasLink() ? $this->getRelations($ownRelations->getLink()) : $ownRelations;
    }

    private function getOwnRelations(?NodeInterface $node): TreeRelations
    {
        $relations = $this->relationMap->get($node?->getUid(), null);
        if ($relations === null) {
            $relations = new TreeRelations();
            $this->relationMap->put($node?->getUid(), $relations); 
        }
        return $relations;
    }

    private function removeRelations(?NodeInterface $node): self
    {
        if ($this->relationMap->hasKey($node?->getUid())) {
            $this->relationMap->remove($node?->getUid()); 
        }
        return $this;
    }
}
