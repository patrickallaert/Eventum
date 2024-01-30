<?php

declare(strict_types=1);

namespace Eventum\Entity;

use Eventum\Enum\Language;

readonly class TranslatedString
{
    /**
     * @var array{fr:string,nl:string}
     */
    private array $content;

    public function __construct(
        string $fr,
        string $nl,
    ) {
        $this->content = [
            Language::French->value => $fr,
            Language::Dutch->value => $nl,
        ];
    }

    public function in(Language $lang): string
    {
        return $this->content[$lang->value];
    }
}
