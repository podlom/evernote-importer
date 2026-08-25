<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Note;

final class FrontMatterRenderer
{
    public function render(
        Note $note
    ): string {
        $notebook = $this->renderNotebook($note);

        $tags = $this->renderTags(
            $note->tags
        );

        $created = $note->createdAt?->format(
            'Y-m-d H:i:s'
        );

        $updated = $note->updatedAt?->format(
            'Y-m-d H:i:s'
        );

        return <<<YAML
---
title: "{$note->title}"
{$notebook}
tags:
{$tags}
author: "{$note->author}"
created: "{$created}"
updated: "{$updated}"
---

YAML;
    }

    private function renderNotebook(
        Note $note
    ): string {
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
