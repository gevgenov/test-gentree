<?php declare (strict_types=1);

namespace Trees;

use SplFixedArray;
use Trees\Interfaces\NodeInterface;

class TreeService
{
    public function format(Tree $tree): array
    {
        return $this->formatNodeList($tree, null, $tree->getChildrenList());
    }

    public function formatNodeList(Tree $tree, ?NodeInterface $parentNode, iterable $nodeList): array
    {
        $nodeListArray = [];
        foreach ($nodeList as $node) {
            $nodeListArray[] = $this->formatNode($tree, $parentNode, $node);
        }
        return $nodeListArray;
    }

    public function formatNode(Tree $tree, ?NodeInterface $parentNode, NodeInterface $node): array
    {
        $nodeArray = [
            'itemName' => $node->getItemName(),
            'parent' => $parentNode?->getItemName(),
            'children' => $this->formatNodeList($tree, $node, $tree->getChildrenList($node)),
        ];
        return $nodeArray;
    }
}
