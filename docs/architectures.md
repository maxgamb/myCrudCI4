# Architectures

myCrudCI4 supports three progressive architectures.

## Basic

Generated components include:

- Model
- web Controller
- validation
- Bootstrap CRUD views
- routes
- pagination
- server-side filters
- controlled sorting
- CSV export
- Word HTML export

Basic is intended for straightforward CRUD applications that do not require a Service/Entity layer.

## Standard

Standard includes everything in Basic plus:

- Entity
- Service
- persistent Service Extension Point

The Service Extension file is create-only and is not overwritten by regeneration.

## Full

Full includes Standard plus:

- REST API v1
- API validation
- API Resource
- OpenAPI description

Use Full when the generated CRUD also needs to act as an application backend.

## Progressive design

The same table configuration is used across architectures. Changing architecture changes the generated layers, not the database schema.

You can override architecture from the CLI:

```bash
php spark mycrud:generate film --architecture=basic
php spark mycrud:generate film --architecture=standard
php spark mycrud:generate film --architecture=full
```
