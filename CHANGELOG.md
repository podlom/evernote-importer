# Changelog

## v0.3.0
- Added ENML media resolving
- Added resource hashes


## v0.4.0
- Added Markdown exporter
- Added metadata front matter
- Added attachment export


## [0.5.0] - 2026-08-22

### Added

- Markdown export with embedded resources
- Automatic resource export during Markdown generation
- ENML media conversion to Markdown image references
- ENML wrapper cleanup during Markdown export

### Improved

- Markdown output now produces cleaner migration-friendly files
- Embedded Evernote images are preserved in exported notes


## v0.6.0 - Export Pipeline Architecture

### Added

- ExportPipeline orchestration layer
- ExportContext for export configuration
- ExportResult with export statistics
- Full export integration test using real Evernote backup
- Resource filename generator

### Changed

- MarkdownExporter now focuses only on note rendering
- Export responsibilities moved into dedicated services
- Improved PHP 8.5 compatibility

### Testing

- PHPUnit 11
- PHP 8.5
- 34 tests
- 73 assertions