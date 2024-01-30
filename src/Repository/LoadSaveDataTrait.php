<?php

declare(strict_types=1);

namespace Eventum\Repository;

trait LoadSaveDataTrait
{
    private readonly string $filename;

    /**
     * @internal
     * @return list<array<string,mixed>>
     */
    public function loadData(): array
    {
        if (\file_exists($this->filename)) {
            $fileData = \file_get_contents($this->filename);

            if (!\is_string($fileData)) {
                throw new \RuntimeException("A problem occurred loading the file $this->filename");
            }

            $data = \json_decode($fileData, true, 10, \JSON_THROW_ON_ERROR);

            if (\is_array($data)) {
                return $data;
            }
        }

        return [];
    }

    /**
     * @param mixed[] $data
     */
    private function saveData(array $data): void
    {
        \file_put_contents($this->filename, \json_encode($data, \JSON_THROW_ON_ERROR));
    }

    public function resetData(): void
    {
        if (\file_exists($this->filename)) {
            \unlink($this->filename);
        }
    }
}
