<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\DTO\EvernoteDocument;
use Podlom\EvernoteImporter\Parser\EnmlCleaner;
use Podlom\EvernoteImporter\Parser\EnmlMediaResolver;
use Podlom\EvernoteImporter\Exporter\FilenameGenerator;

final class MarkdownExporter implements ExporterInterface
{
    public function __construct(
        private readonly ResourceExporter $resourceExporter = new ResourceExporter(),
        private readonly EnmlMediaResolver $mediaResolver = new EnmlMediaResolver(),
        private readonly FrontMatterRenderer $frontMatterRenderer = new FrontMatterRenderer(),
        private readonly EnmlCleaner $cleaner = new EnmlCleaner(),
        private readonly FilenameGenerator $filenameGenerator = new FilenameGenerator(),
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
                $notesDirectory.'/'.$this->filenameGenerator->generate($note->title),
                $this->render($note)
            );
        }
    }

    private function render(
        Note $note
    ): string {
        $content = $this->mediaResolver->resolve(
            $note->content,
            $note->resources
        );

        $content = $this->cleaner->clean(
            $content
        );

        $frontMatter = $this->frontMatterRenderer->render(
            $note
        );

        return $frontMatter.$content."\n";
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
