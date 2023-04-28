<?php declare (strict_types=1);

namespace App\Console\Commands;

use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Io\Readers\CsvFileReader;
use Io\Writers\JsonFileWriter;
use Trees\NodeService;
use Trees\TreeService;
use Trees\Factories\TreeFactory;
use Trees\Tree;

#[AsCommand(
    name: 'gentree',
    description: 'Generates JSON tree from CSV file.',
)]
class GentreeCommand extends Command
{
    public function __construct (
        private NodeService $nodeService,
        private TreeService $treeService,
        private TreeFactory $treeFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('input-path', InputArgument::REQUIRED, 'Input file path')
            ->addArgument('output-path', InputArgument::REQUIRED, 'Output file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tree = $this->getTree($input);
        $treeArray = $this->treeService->format($tree);
        (new JsonFileWriter(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR))(
            $treeArray, 
            $this->getOutputPath($input)
        );

        return Command::SUCCESS;
    }

    private function getTree(InputInterface $input): Tree
    {
        $csvReader = new CsvFileReader($this->getInputPath($input));
        $nodeGenerator = $this->nodeService->createGeneratorFromRecordList($csvReader);
        return $this->treeFactory->createFromNodeList($nodeGenerator);
    }

    private function getInputPath(InputInterface $input): string
    {
        $path = $input->getArgument('input-path');
        if (!is_file($path)) {
            throw new RuntimeException('Invalid input path!'); 
        }
        return $path;
    }

    private function getOutputPath(InputInterface $input): string
    {
        $path = $input->getArgument('output-path');
        if (!is_dir(dirname($path))) {
            throw new RuntimeException('Invalid output path!'); 
        }
        return $path;
    }
}
