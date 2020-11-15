<?php

namespace Parser;

use Parser\ParserException;
use Parser\ParserInterface;
use Parser\ServiceAbstractClass;
use Parser\CsvParser;

class Service
{

    protected string $filePath;

    protected string $mode = 'r';

    protected ParserInterface $parser;

    public function __construct(string $filePath, ParserInterface $parser)
    {
        $this->setFilePath($filePath);
        $this->setParser($parser);
    }


    public function setParser(ParserInterface $parser): void {
        $this->parser = $parser;
    }

    public function setFilePath(string $filePath): void {
        $this->filePath = $filePath;
    }

    public function parse(bool $byKey = true): array {
        $handle = $this->open();

        $data = $this->parser->parse($handle, $byKey);

        fclose($handle);

        return $data;
    }

    protected function open() {
        if(!file_exists($this->filePath)) {
            throw new ParserException('File does not exist!');
        }

        return $this->handle();
    }

    protected function handle() {
        $handle = fopen(
            $this->filePath,
            $this->mode
        );

        return $handle;
    }

}
