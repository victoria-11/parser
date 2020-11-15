<?php

namespace Parser;

use Parser\ParserInterface;
use Parser\ParserException;

class CsvParser implements ParserInterface
{

    protected $handle;

    protected string $delimiter = ',';

    protected int $length = 1000;

    protected bool $hasHeaders = true;

    protected array $headers = [];

    public function parse($handle, bool $byKey): array {
        if(!is_resource($handle)) {
            throw new ParserException('Something went wrong!');
        }

        $this->handle = $handle;

        return $this->getData($byKey);
    }

    public function setDelimiter(string $delimiter): void {
        $this->delimiter = $delimiter;
    }

    public function setHasHeaders(bool $hasHeaders): void {
        $this->hasHeaders = $hasHeaders;
    }

    public function setHeaders(array $headers): void {
        $this->headers = $headers;
    }

    public function setLength(int $length): void {
        $this->length = $length;
    }

    protected function parseHeaders(): void {
        if($this->hasHeaders) {
            $this->headers = $this->getCsv();
        }
    }

    protected function getData(bool $byKey): array {
        $this->parseHeaders();

        $data = [];

        $i = 0;
        $max = 100;

        while ($row = $this->getCsv()) {
            if($byKey) {
                $row = $this->buildKeys($row);
            }

            $data[] = $row;

            $i++;
        }

        return $data;
    }

    protected function buildKeys(array $row): array {
        if(empty($this->headers)) {
            throw new ParserException('Your data has no headers!');
        }

        $row = array_combine($this->headers, $row);

        return $row;
    }

    protected function getCsv(): ?array {
        $result = fgetcsv($this->handle, $this->length, $this->delimiter);

        if(!$result) {
            $result = null;
        }

        return $result;
    }

}
