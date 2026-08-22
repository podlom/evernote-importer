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

            $content = preg_replace(
                '/<en-media[^>]*hash="'
                .$resource->hash
                .'"[^>]*\/>/',
                '![image](../resources/'.$resource->filename.')',
                $content
            );
        }

        return $content;
    }
}
