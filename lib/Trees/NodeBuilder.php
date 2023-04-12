<?php declare (strict_types=1);

namespace Trees;

use UnexpectedValueException;
use Trees\Interfaces\NodeInterface;
use Trees\Interfaces\NodeBuilderInterface;

class NodeBuilder implements NodeBuilderInterface
{
    private ?string $itemName = null;
    private ?string $parent = null;
    private ?string $relation = null;

    public function create(): self
    {
        return new self();
    }

    public function setItemName(string $str): self
    {
        $this->itemName = $str;
        return $this;
    }

    public function setParent(?string $str): self
    {
        $this->parent = $str;
        return $this;
    }

    public function setRelation(?string $str): self
    {
        $this->relation = $str;
        return $this;
    }

    public function build(): NodeInterface
    {
        $this->assertItemName();
        return new Node(
            $this->itemName,
            $this->parent,
            $this->relation,
        );
    }

    public function assertItemName(): void
    {
        if (is_null($this->itemName)) {
            throw new UnexpectedValueException('Missing required paramater: "itemName"!');
        }
    }
}
