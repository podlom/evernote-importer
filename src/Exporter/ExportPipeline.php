<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\EvernoteDocument;

final class ExportPipeline
{
    public function __construct(
        private readonly ResourceExporter $resourceExporter = new ResourceExporter(),
        private readonly MarkdownExporter $markdownExporter = new MarkdownExporter(),
    ) {
    }

    public function export(
        EvernoteDocument $document,
        ExportContext $context
    ): ExportResult {
        $notes = 0;
        $resources = 0;

        foreach ($document->notes as $note) {

            foreach ($note->resources as $resource) {
                $this->resourceExporter->export(
                    $resource,
                    $context->destination.'/resources'
                );

                $resources++;
            }

            $this->markdownExporter->export(
                new EvernoteDocument([$note]),
                $context->destination
            );

            $notes++;
        }

        return new ExportResult(
            notesExported: $notes,
            resourcesExported: $resources,
        );
    }
}
