<?php declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Records\CsvRecordReader;
use Trees\NodeBuilder;
use Trees\TreeBuilder;
use Support\Objects\IoPaths;

class Gentree {

    private IoPaths $paths;
    private TreeService $treeService;

    public function execute()
    {
        try {
            $this->process();
        } catch (Throwable $t) {
            fwrite(STDERR, sprintf("%s:%s:%d: %s\n", $_SERVER['argv'][0], $t->getFile(), $t->getLine(), $t->getMessage()));
            exit(1);
        }
    }

    private function process(): void
    {
        $this->init();
        $tree = $this->read();
        $this->write($tree);
    }

    private function init(): self
    {
        if ($_SERVER['argc'] !== 3) {
            throw new InvalidArgumentException('This command accepts two arguments!');
        }
        $this->paths = new IoPaths($_SERVER['argv'][1], $_SERVER['argv'][2]);
        $this->treeService = new TreeService(new NodeFactory());
        return $this;
    }
    
    private function read(): Tree
    {
        $recordReader = new CsvRecordReader($this->paths->input);
        return $this->treeService->createFromRecordIterable($recordReader);
    }

    private function write(Tree $tree): self
    {
        $treeJson = $this->treeService->toJson($tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        if (!file_put_contents(
            $this->paths->output,
            $treeJson,
        )) {
            throw new RuntimeException(sprintf('Failed to write a file: "%s"!', $this->paths->output));
        }
        return $this;
    }
}

(new Gentree())->execute();
