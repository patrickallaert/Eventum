<?php

declare(strict_types=1);

namespace Eventum\Repository;

trait LoadSaveDataTrait
{
    private readonly string $filename;

    private function saveData(\SimpleXMLElement $data): void
    {
        if ($data->asXML($this->filename) === false) {
            throw new \RuntimeException("An error occurred saving the data!");
        }
    }

    public function resetData(): void
    {
        if (\file_exists($this->filename)) {
            \unlink($this->filename);
        }
    }
}
