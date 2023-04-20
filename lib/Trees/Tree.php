<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;
use Ds\Map;
use Ds\Vector;

class Tree
{
    private Map $parentMap;
    private Map $childrenMap;

    public function __construct()
    {
        $this->parentMap = new Map();
        $this->childrenMap = new Map();
    }

    public function hasParent(NodeInterface $node): bool
    {
        return $this->parentMap->hasKey($node->getUid()); 
    }

    public function getParent(NodeInterface $node): ?NodeInterface
    {
        return $this->parentMap->get($node->getUid(), null); 
    }

    public function setParent(NodeInterface $node, ?NodeInterface $parentNode = null): self
    {
        $oldParentNode = $this->parentMap->get($node->getUid(), null);
        if (!is_null($oldParentNode)) {
            $oldParentNodeChildren = $childrenMap->get($oldParentNode->getUid());
            if ($oldParentNodeChildren->hasKey($node->getUid())) {
                $oldParentNodeChildren->remove($node->getUid());
            }
        }
        $this->parentMap->put($node->getUid(), $parentNode); 
        $parentNodeChildren = $this->childrenMap->get($parentNode?->getUid(), null);
        if (is_null($parentNodeChildren)) {
            $parentNodeChildren = new Map();
            $this->childrenMap->put($parentNode?->getUid(), $parentNodeChildren);
        }
        $parentNodeChildren->put($node->getUid(), $node);
        return $this; 
    }

    public function hasChildren(?NodeInterface $node = null): bool
    {
        return count($this->childrenMap->get($node, [])) > 0;
    }

    public function getChildren(?NodeInterface $node = null): iterable
    {
        return $this->childrenMap->get($node, []);    
    }

    public function getChildrenCount(?NodeInterface $node = null): int
    {
        return count($this->childrenMap->get($node, []));    
    }

    public function forgetNode(NodeInterface $node): self
    {
    }
}
