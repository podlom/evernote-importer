<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\Exporter\FrontMatterRenderer;

final class FrontMatterRendererTest extends TestCase
{
    public function test_renders_front_matter(): void
    {
        $note = new Note(
            title: 'Test Laravel Note',
            content: 'Note content',
            tags: [
                'Laravel',
                'PHP',
            ],
            author: 'Taras Shkodenko',
            notebook: 'Laravel Course',
            createdAt: new DateTimeImmutable(
                '2026-08-25 10:00:00'
            ),
            updatedAt: new DateTimeImmutable(
                '2026-08-25 11:00:00'
            ),
        );

        $renderer = new FrontMatterRenderer();

        $frontMatter = $renderer->render(
            $note
        );

        self::assertStringContainsString(
            'title: "Test Laravel Note"',
            $frontMatter
        );

        self::assertStringContainsString(
            'notebook: "Laravel Course"',
            $frontMatter
        );

        self::assertStringContainsString(
            'tags:',
            $frontMatter
        );

        self::assertStringContainsString(
            '  - "Laravel"',
            $frontMatter
        );

        self::assertStringContainsString(
            '  - "PHP"',
            $frontMatter
        );

        self::assertStringContainsString(
            'author: "Taras Shkodenko"',
            $frontMatter
        );

        self::assertStringContainsString(
            'created: "2026-08-25 10:00:00"',
            $frontMatter
        );

        self::assertStringContainsString(
            'updated: "2026-08-25 11:00:00"',
            $frontMatter
        );
    }

    public function test_does_not_render_empty_notebook(): void
    {
        $note = new Note(
            title: 'Simple Note',
            content: 'Content',
            tags: [
                'PHP',
            ],
        );

        $renderer = new FrontMatterRenderer();

        $frontMatter = $renderer->render(
            $note
        );

        self::assertStringNotContainsString(
            'notebook:',
            $frontMatter
        );
    }

    public function test_renders_empty_tags(): void
    {
        $note = new Note(
            title: 'Note Without Tags',
            content: 'Content',
        );

        $renderer = new FrontMatterRenderer();

        $frontMatter = $renderer->render(
            $note
        );

        self::assertStringContainsString(
            "tags:\n",
            str_replace(
                "\r\n",
                "\n",
                $frontMatter
            )
        );
    }
}
