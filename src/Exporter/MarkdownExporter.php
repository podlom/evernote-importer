<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\DTO\EvernoteDocument;
use Podlom\EvernoteImporter\Parser\EnmlMediaResolver;

final class MarkdownExporter implements ExporterInterface
{
    public function __construct(
        private readonly ResourceExporter $resourceExporter = new ResourceExporter(),
        private readonly EnmlMediaResolver $mediaResolver = new EnmlMediaResolver(),
    ) {
    }

    public function export(
        EvernoteDocument $document,
        string $destination
    ): void {
        $notesDirectory = $destination.'/notes';

        $this->ensureDirectory($notesDirectory);

        $resourcesDirectory = $destination.'/resources';

        $this->ensureDirectory($resourcesDirectory);

        foreach ($document->notes as $note) {

            foreach ($note->resources as $resource) {
                $this->resourceExporter->export(
                    $resource,
                    $resourcesDirectory
                );
            }

            file_put_contents(
                $notesDirectory.'/'.$this->filename($note->title),
                $this->render($note)
            );
        }
    }

    private function filename(string $title): string
    {
        $safe = preg_replace(
            '/[\\\\\/:*?"<>|]/',
            '-',
            $title
        );

        return $safe . '.md';
    }

    private function render(Note $note): string
    {
        $content = $this->mediaResolver->resolve(
            $note->content,
            $note->resources
        );

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

{$content}

MARKDOWN;
    }

    private function ensureDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            mkdir(
                $directory,
                0777,
                true
            );
        }
    }
}
