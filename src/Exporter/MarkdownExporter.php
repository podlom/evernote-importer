<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\EvernoteDocument;

final class MarkdownExporter implements ExporterInterface
{
    public function export(
        EvernoteDocument $document,
        string $destination
    ): void {
        $notesDirectory = $destination.'/notes';

        if (!is_dir($notesDirectory)) {
            mkdir(
                $notesDirectory,
                0777,
                true
            );
        }

        foreach ($document->notes as $note) {
            file_put_contents(
                $notesDirectory.'/'.$this->filename($note->title),
                $this->render($note)
            );
        }
    }

    private function filename(string $title): string
    {
        return $title.'.md';
    }

    private function render($note): string
    {
        $tags = implode(
            ', ',
            $note->tags
        );

        $created = $note->createdAt?->format(
            'Y-m-d H:i:s'
        );

        $updated = $note->updatedAt?->format(
            'Y-m-d H:i:s'
        );

        return <<<MARKDOWN
---
title: "{$note->title}"
tags:
  - {$tags}
author: "{$note->author}"
created: "{$created}"
updated: "{$updated}"
---

{$note->content}

MARKDOWN;
    }
}
