<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\DTO\EvernoteDocument;
use Podlom\EvernoteImporter\Parser\EnmlCleaner;
use Podlom\EvernoteImporter\Parser\EnmlMediaResolver;

final class MarkdownExporter implements ExporterInterface
{
    public function __construct(
        private readonly ResourceExporter $resourceExporter = new ResourceExporter(),
        private readonly EnmlMediaResolver $mediaResolver = new EnmlMediaResolver(),
        private readonly EnmlCleaner $cleaner = new EnmlCleaner(),
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

        $content = $this->cleaner->clean(
            $content
        );

        $tags = $this->renderTags(
            $note->tags
        );

        $created = $note->createdAt?->format(
            'Y-m-d H:i:s'
        );

        $updated = $note->updatedAt?->format(
            'Y-m-d H:i:s'
        );

        $notebook = $this->renderNotebook($note);

        return <<<MARKDOWN
---
title: "{$note->title}"
{$notebook}
tags:
{$tags}
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

    private function renderNotebook(Note $note): string
    {
        if ($note->notebook === null) {
            return '';
        }

        return 'notebook: "'.$note->notebook.'"';
    }

    private function renderTags(
        array $tags
    ): string {
        if ($tags === []) {
            return '';
        }

        return implode(
            "\n",
            array_map(
                fn(string $tag) => '  - "'.$tag.'"',
                $tags
            )
        );
    }
}
