<?php

namespace Scripts;

use Scripts\ScriptInterface;

use Medoo\Medoo;

use Parser\CsvParser;
use Parser\Service;

class CsvParsing implements ScriptInterface {

    protected CsvParser $parser;

    protected Service $service;

    protected Medoo $db;

    protected int $chunksCount = 3000;

    public function __construct(string $filePath, Medoo $db) {
        $this->parser = new CsvParser();
        $this->db = $db;

        $delimiter = '|';

        $this->parser->setDelimiter($delimiter);

        $this->service = new Service($filePath, $this->parser);
    }

    public function run(): void {
        $byKey = true;

        $data = $this->service->parse($byKey);

        $this->saveData($data);
    }


    protected function saveData(array $data): void {
        $categories = $this->getCategories();

        $chunks = array_chunk($data, $this->chunksCount);

        foreach ($chunks as $chank) {
            $userData = [];

            foreach ($chank as $row) {
                $row['category_id'] = $this->getCategoryId($categories, $row);

                $userData[] = $this->prepareData($row);
            }

            $this->db->insert('users', $userData);

            $this->checkErrors();
        }
    }

    protected function checkErrors(): void {
        $error = $this->db->error()[2] ?? null;

        if($error) {
            throw new \Exception($error);
        }
    }

    protected function prepareData(array $row): array {
        return [
            'full_name' => $row['full_name'],
            'phone' => $row['phone'],
            'category_id' => $row['category_id'],
            'date_of_birth' => $row['date_of_birth'],
            'days' => $row['days'],
        ];
    }

    protected function getCategoryId(array $categories, array $row): ?int {
        $category = mb_strtolower(trim($row['category']));

        return $categories[$category] ?? null;
    }

    protected function getCategories(): array {
        $result = [];

        $categories = $this->db->select('categories', [
            'id',
            'name'
        ]);

        return $this->buildMap($categories);
    }

    protected function buildMap(array $data): array {
        $result = [];

        foreach ($data as $value) {
            $key = mb_strtolower($value['name']);

            $result[$key] = $value['id'];
        }

        return $result;
    }
}
