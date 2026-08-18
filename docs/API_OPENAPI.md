# REST API and OpenAPI

REST API generation is available in Full architecture.

## Capabilities

Per-table capabilities can enable or disable:

- list;
- read;
- create;
- update;
- delete;
- trash;
- restore;
- force delete;
- upload.

Generated routes, controllers, OpenAPI operations, and contract tests follow the
same capability configuration.

## OpenAPI

OpenAPI uses stable operation IDs such as:

```text
listFilm
createFilm
getFilm
updateFilm
patchFilm
deleteFilm
uploadFilm
```

Real file/image uploads are described as `multipart/form-data` with binary fields.

## Shield

CodeIgniter Shield integration is optional and has two independent configuration boundaries. Web CRUD uses `crudSecurity` with Shield session authentication and optional per-action permissions. REST API uses `apiSecurity` with Bearer Access Tokens and optional per-capability permissions.

Generated REST permissions can use names such as:

```text
film.list
film.read
film.create
film.update
film.delete
film.upload
```

myCrudCI4 does not install Shield automatically. Web CRUD session security does not implicitly enable REST token security, and REST token security does not implicitly protect Web CRUD routes.


## Architecture boundary (2.9.1-dev24-fix11-fix8)

Generated Full REST APIs follow the same application boundary as the Web CRUD:

- `ApiController -> Model` for reads;
- `ApiController -> Service` for writes;
- `Resource` is output-only serialization;
- `OpenAPI` describes the REST contract only;
- Web transport details such as `_related_new`, `_related`, `_many_new`, `_many_related`, and Offcanvas state are not REST fields.

Relation ownership remains explicit and static. API code must not resolve Models, Services, or tables dynamically from runtime metadata.


## API boundary cleanup (2.9.1-dev24-fix11-fix9)

REST Resources are output-only serializers. Filter/sort/write policies live in the ApiController. File/image fields are not accepted as persisted filenames in normal request payloads; generated multipart handling uses CrudUploadManager.
