<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\Parser\EnmlCleaner;
use Podlom\EvernoteImporter\Parser\EnmlMediaResolver;

final class MarkdownExporter implements NoteExporterInterface
{
    public function __construct(
        private readonly EnmlMediaResolver $mediaResolver = new EnmlMediaResolver(),
        private readonly FrontMatterRenderer $frontMatterRenderer = new FrontMatterRenderer(),
        private readonly EnmlCleaner $cleaner = new EnmlCleaner(),
        private readonly FilenameGenerator $filenameGenerator = new FilenameGenerator(),
    ) {
    }

    public function exportNote(
        Note $note,
        string $destination
    ): string {
        $notesDirectory = $destination.'/notes';

        $this->ensureDirectory(
            $notesDirectory
        );

        $path = $notesDirectory.'/'
            .$this->filenameGenerator->generate(
                $note->title
            );

        file_put_contents(
            $path,
            $this->render($note)
        );

        return $path;
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
}
