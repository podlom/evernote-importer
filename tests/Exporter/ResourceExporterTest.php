<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\DTO\Resource;
use Podlom\EvernoteImporter\Exporter\ResourceExporter;

final class ResourceExporterTest extends TestCase
{
    public function test_exports_resource_file(): void
    {
        $destination = sys_get_temp_dir()
            .'/resource-export-test';

        if (is_dir($destination)) {
            $this->removeDirectory($destination);
        }

        $resource = new Resource(
            mimeType: 'image/jpeg',
            hash: 'abc123',
            filename: 'photo.jpg',
            data: base64_encode('image-content'),
        );

        $exporter = new ResourceExporter();

        $path = $exporter->export(
            $resource,
            $destination
        );

        self::assertFileExists($path);

        self::assertSame(
            'image-content',
            file_get_contents($path)
        );
    }

    private function removeDirectory(string $directory): void
    {
        foreach (glob($directory.'/*') ?: [] as $file) {
            is_dir($file)
                ? $this->removeDirectory($file)
                : unlink($file);
        }

        rmdir($directory);
    }
}
