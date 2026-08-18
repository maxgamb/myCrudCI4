# Uploads

myCrudCI4 supports generated `file` and `image` form inputs.

## Storage

The default physical storage is:

```text
writable/uploads/
```

No per-record subdirectories are required.

The default filename convention is:

```text
<table>_<id>_<field>_<random>.<ext>
```

Example:

```text
customers_125_photo_a8f31c2d.jpg
```

The database stores the filename rather than an absolute server path.

## Global configuration

Upload defaults are centralized in:

```text
app/Config/MyCrud.php
```

Example:

```php
public array $upload = [
    'directory' => WRITEPATH . 'uploads',
    'maxSize' => 5120,
    'imageExtensions' => [
        'jpg', 'jpeg', 'png', 'webp',
    ],
    'fileExtensions' => [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv',
    ],
];
```

`maxSize` is expressed in KB.

## Create workflow

For a new record:

1. validate normal data and upload;
2. insert the record;
3. obtain the primary key;
4. store the file with the generated name;
5. update the record with the stored filename.

## Edit workflow

If no new file is uploaded, the existing filename is preserved. When a file is replaced, the generated runtime manages the replacement workflow.

## Display

Uploads remain outside `public/`. Generated Controllers can serve authorized configured upload fields through a record-aware endpoint.

Images can be rendered as thumbnails/previews; generic files are rendered as links.

## Security

Extension and size checks are defaults, not a replacement for application-specific authorization. Review upload rules for your deployment.
