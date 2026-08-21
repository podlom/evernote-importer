<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\DTO\Resource;

final class EnmlMediaResolver
{
    /**
     * @param Resource[] $resources
     */
    public function resolve(
        string $content,
        array $resources
    ): string {
        foreach ($resources as $resource) {
            if ($resource->hash === null) {
                continue;
            }

            $content = str_replace(
                'hash="'.$resource->hash.'"',
                'src="resources/'.$resource->filename.'"',
                $content
            );
        }

        return $content;
    }
}
