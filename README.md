# Evernote Importer

[![Tests](https://github.com/podlom/evernote-importer/actions/workflows/phpunit.yml/badge.svg)](https://github.com/podlom/evernote-importer/actions)

A PHP library for importing Evernote ENEX exports into a structured, application-friendly format.

The goal of this project is to help users migrate their Evernote data to open formats and alternative platforms while keeping their notes, metadata, and attachments accessible.

## Features

### Current

- ✅ Import Evernote ENEX files
- ✅ Import single and multiple notes
- ✅ Extract note metadata
- ✅ Extract note titles
- ✅ Extract tags
- ✅ Extract authors
- ✅ Parse Evernote ENML content
- ✅ Extract embedded resources
- ✅ Preserve resource hashes
- ✅ Resolve embedded images and media references

### Roadmap

- 🚧 Markdown export
- 🚧 HTML export
- 🚧 JSON export
- 🚧 Resource file extraction
- 🚧 Laravel integration
- 🚧 Search and indexing support

## Requirements

- PHP 8.3+
- ext-dom
- ext-simplexml

## Installation

Install via Composer:

```bash
composer require podlom/evernote-importer
````

## Basic usage

```php
use Podlom\EvernoteImporter\EnexImporter;

$importer = new EnexImporter();

$document = $importer->import(
    'backup.enex'
);

foreach ($document->notes as $note) {
    echo $note->title;
}
```

## Imported data structure

The importer converts ENEX files into structured PHP objects.

Example note structure:

```php
Note {
    title
    content
    tags[]
    author
    createdAt
    updatedAt
    resources[]
}
```

Example:

```php
foreach ($document->notes as $note) {
    echo $note->title;
    echo $note->content;

    foreach ($note->resources as $resource) {
        echo $resource->filename;
    }
}
```

## Supported Evernote data

Currently supported:

| Data                  | Status |
| --------------------- | ------ |
| Note title            | ✅      |
| Note content          | ✅      |
| Tags                  | ✅      |
| Author                | ✅      |
| Created date          | ✅      |
| Updated date          | ✅      |
| Embedded images       | ✅      |
| Attachments/resources | ✅      |
| Resource hashes       | ✅      |

## Project status

The package is under active development.

Current milestone:

```
v0.3.x

✓ ENEX parsing
✓ ENML content parsing
✓ Resource extraction
✓ Embedded media resolving
```

Next milestone:

```
v0.4.x

- Markdown export
- Attachment export
- Migration-friendly directory structure
```

## Example migration workflow

The planned workflow:

```
Evernote ENEX export
          |
          v
  Evernote Importer
          |
          v
 EvernoteDocument
          |
          +----------------+
          |                |
          v                v
    Markdown export    JSON export
          |
          v
  Open formats and other platforms
```

## Why this project?

Evernote users increasingly need a way to keep ownership of their notes and migrate their data to open formats.

This project focuses on making Evernote exports:

* portable
* reusable
* independent from a single platform

The long-term goal is to provide a reliable migration toolkit for Evernote users.

## Development

Clone the repository:

```bash
git clone https://github.com/podlom/evernote-importer.git

cd evernote-importer
```

Install dependencies:

```bash
composer install
```

Run tests:

```bash
vendor/bin/phpunit --testdox
```

## License

MIT
