<?php

namespace ArtARTs36\MergeRequestLinter\Report\Reporter\Http;

use ArtARTs36\MergeRequestLinter\Report\Metrics\Record;

class RecordMapper
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return array<mixed>
     */
    public function map(Record $record): array
    {
        return [
            'subject' => [
                'key' => $record->subject->key,
                'name' => $record->subject->name,
            ],
            'value' => $record->getValue(),
            'date' => $record->date->format(self::DATE_FORMAT),
        ];
    }
}
