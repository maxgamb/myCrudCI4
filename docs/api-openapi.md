# REST API and OpenAPI

The **Full** architecture generates REST API scaffolding together with an OpenAPI description.

## Typical generated endpoints

For a table such as `film`:

```text
GET    /api/v1/film
GET    /api/v1/film/{id}
POST   /api/v1/film
PUT    /api/v1/film/{id}
PATCH  /api/v1/film/{id}
DELETE /api/v1/film/{id}
```

The exact routes depend on whether the table is writable and supports record detail.

## OpenAPI

OpenAPI describes the generated API in a machine-readable form. It can be used for:

- API documentation;
- Swagger/OpenAPI tooling;
- client generation;
- integration testing;
- AI/tool integrations that understand OpenAPI contracts.

OpenAPI does not execute requests by itself. The generated API Controller provides the behavior; OpenAPI describes that behavior.

## SQL views

SQL views are treated as read-only sources. Full architecture can expose read-only API operations without generating write semantics for the underlying view query.

## Security

API generation does not remove the need for authentication and authorization. Before exposing write APIs, integrate the generated endpoints with the security layer used by your application.
