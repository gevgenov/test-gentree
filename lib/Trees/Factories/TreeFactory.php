<?php declare (strict_types=1);

namespace Trees\Factories;

use Trees\Tree;
use Trees\Interfaces\NodeInterface;
use Ds\Map;

class TreeFactory
{
    public function createFromNodeList(iterable $nodeList): Tree
    {
        $nodeMap = new Map();
        foreach ($nodeList as $node) {
            $nodeMap->put($node->getItemName(), $node);
        }
        $tree = new Tree(); 
        foreach ($nodeMap as $node) {
            $tree->setParent($node, $nodeMap->get($node->getParent(), null));
        }
        foreach ($nodeMap as $node) {
            if (!$node->hasRelation() || !$nodeMap->hasKey($node->getRelation())) continue;
            $relatedNode = $nodeMap->get($node->getRelation());
            $tree->setLink($node, $relatedNode);
        }
        return $tree;
    }
}
