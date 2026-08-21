# Evernote Importer

PHP library for importing Evernote ENEX exports.

## Features

- Import notes
- Import tags
- Parse ENML
- Extract resources
- Resolve embedded images

## Requirements

- PHP 8.3+

## Example

```php
$importer = new EnexImporter();

$document = $importer->import(
    'backup.enex'
);
```
