<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Config;

use RuntimeException;

/**
 * Repository della persistent configuration del Menu Builder.
 *
 * Menu configuration is a project-level choice and does not belong to a
 * single table. Therefore it is saved in a dedicated subdirectory and
 * is not mixed with app/MyCrudConfig/<table>.php.
 */
final class MenuConfigRepository
{
    private string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? APPPATH . 'MyCrudConfig/Project/Menu.php';
    }

    /** @return array<string,mixed>|null */
    public function load(): ?array
    {
        if (!is_file($this->path)) {
            return null;
        }

        $loaded = (static function (string $file): mixed {
            return require $file;
        })($this->path);

        if (!is_array($loaded)) {
            throw new RuntimeException('Invalid menu configuration: ' . $this->path);
        }

        return $loaded;
    }

    /** @return string percorso scritto */
    public function save(array $menu): string
    {
        $directory = dirname($this->path);
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('Unable to create the menu configuration directory.');
        }

        $menu['_meta'] = [
            'generatorVersion' => (string) config('MyCrud')->version,
            'savedAt' => date(DATE_ATOM),
        ];

        $content = "<?php\n\n"
            . "declare(strict_types=1);\n\n"
            . "/**\n"
            . " * Persistent configuration del Menu Builder myCrudCI4.\n"
            . " * Il file descrive la navigazione scelta dallo sviluppatore.\n"
            . " */\n"
            . 'return ' . var_export($menu, true) . ";\n";

        $tmp = $this->path . '.tmp-' . bin2hex(random_bytes(4));
        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new RuntimeException('Unable to save temporary menu configuration.');
        }

        if (!rename($tmp, $this->path)) {
            @unlink($tmp);
            throw new RuntimeException('Unable to publish menu configuration.');
        }

        return $this->path;
    }

    public function path(): string
    {
        return $this->path;
    }
}
