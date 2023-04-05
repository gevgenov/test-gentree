<?php declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Records\CsvRecordReader;
use Trees\TreeBuilder;

try {
    if ($argc !== 3) {
        throw new InvalidArgumentException('This command accepts two arguments!');
    }
    $inputPath = $argv[1];
    $outputPath = $argv[2];

    $recordReader = new CsvRecordReader($inputPath);
    $treeBuilder = new TreeBuilder();
    foreach ($recordReader as $record) {
        $treeBuilder->addRecord($record);
    }
    $rootNode = $treeBuilder->build();

    if (!file_put_contents(
        $outputPath,
        json_encode($rootNode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
    )) {
        throw new RuntimeException(sprintf('Failed to write a file: "%s"!', $outputPath));
    }

} catch (Throwable $t) {
    fwrite(STDERR, sprintf("%s: %s\n", $argv[0], $t));
    exit(1);
}
