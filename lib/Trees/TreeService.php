<?php declare (strict_types=1);

namespace Trees;

use SplFixedArray;
use Trees\Interfaces\NodeInterface;

class TreeService
{
    public function format(Tree $tree): array
    {
        return $this->formatNodeList($tree, $tree->getChildren());
    }

    public function formatNodeList(Tree $tree, iterable $nodes): array
    {
        $list = [];
        foreach ($nodes as $node) {
            $list[] = $this->formatNode($tree, $node);
        }
        return $list;
    }

    public function formatNode(Tree $tree, NodeInterface $node): array
    {
        $nodeArray = [
            'itemName' => $node->getItemName(),
            'parent' => $tree->getParent($node)?->getItemName(),
            'children' => $this->formatNodeList($tree, $tree->getChildren($node)),
        ];
        return $nodeArray;
    }
}
