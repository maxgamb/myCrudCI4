<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Config;

use RuntimeException;

/**
 * Repository della configurazione persistente del Menu Builder.
 *
 * La configurazione del menu è una scelta di progetto e non appartiene a una
 * singola tabella. Per questo viene salvata in una sottocartella dedicata e
 * non viene confusa con app/MyCrudConfig/<tabella>.php.
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
            throw new RuntimeException('Configurazione menu non valida: ' . $this->path);
        }

        return $loaded;
    }

    /** @return string percorso scritto */
    public function save(array $menu): string
    {
        $directory = dirname($this->path);
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('Impossibile creare la directory della configurazione menu.');
        }

        $menu['_meta'] = [
            'generatorVersion' => (string) config('MyCrud')->version,
            'savedAt' => date(DATE_ATOM),
        ];

        $content = "<?php\n\n"
            . "declare(strict_types=1);\n\n"
            . "/**\n"
            . " * Configurazione persistente del Menu Builder myCrudGpt.\n"
            . " * Il file descrive la navigazione scelta dallo sviluppatore.\n"
            . " */\n"
            . 'return ' . var_export($menu, true) . ";\n";

        $tmp = $this->path . '.tmp-' . bin2hex(random_bytes(4));
        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile salvare la configurazione menu temporanea.');
        }

        if (!rename($tmp, $this->path)) {
            @unlink($tmp);
            throw new RuntimeException('Impossibile pubblicare la configurazione menu.');
        }

        return $this->path;
    }

    public function path(): string
    {
        return $this->path;
    }
}
