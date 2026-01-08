<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

class Otras implements Iterator
{
    // Array asociativo con las propiedades dinámicas
    private array $_propie = [];

    // Propiedad privada para acumular importes numéricos
    private float $_TOTAL_IMPORTES = 0.0;

    // Puntero para iteración
    private int $_position = 0;
    private array $_keys = [];


    /**
     * Inicializa el KEYS vacío
     */
    public function __construct()
    {
        $this->resetKeys();
    }

    /**
     * Método mágico SET
     * Guarda propiedades en mayúsculas
     */
    public function __set(string $nombre, mixed $valor): void
    {
        $clave = strtoupper($nombre);

        // Si empieza por "I" → numérico
        if (str_starts_with($clave, "I")) {
            $valor = is_numeric($valor) ? (float)$valor : 0.0;
        } else {
            $valor = (string)$valor;
        }

        $this->_propie[$clave] = $valor;
        $this->actualizaTotal();
        $this->resetKeys();
    }

    /**
     * Método mágico GET
     */
    public function __get(string $nombre): mixed
    {
        $clave = strtoupper($nombre);

        if ($clave === "TOT_IMP") {
            return $this->_TOTAL_IMPORTES;
        }

        return $this->_propie[$clave] ?? null;
    }

    /**
     * Método mágico ISSET
     */
    public function __isset(string $nombre): bool
    {
        $clave = strtoupper($nombre);
        if ($clave === "TOT_IMP") {
            return true;
        }
        return isset($this->_propie[$clave]);
    }

    /**
     * Método mágico UNSET
     */
    public function __unset(string $nombre): void
    {
        $clave = strtoupper($nombre);
        if ($clave === "TOT_IMP") {
            return; // no se puede borrar
        }
        unset($this->_propie[$clave]);
        $this->actualizaTotal();
        $this->resetKeys();
    }

    /**
     * Recalcula TOTAL_IMPORTES
     */
    private function actualizaTotal(): void
    {
        $this->_TOTAL_IMPORTES = 0.0;
        foreach ($this->_propie as $clave => $valor) {
            if (str_starts_with($clave, "I")) {
                $this->_TOTAL_IMPORTES += (float)$valor;
            }
        }
    }

    /**
     * Iterador: preparar claves
     */
    private function resetKeys(): void
    {
        $this->_keys = array_keys($this->_propie);
        $this->_position = 0;
    }

    // Métodos de Iterator
    public function current(): mixed
    {
        $clave = $this->_keys[$this->_position];
        return $this->_propie[$clave];
    }

    public function key(): string
    {
        $clave = $this->_keys[$this->_position];
        // Primera y última letra en mayúscula, resto minúsculas
        if (strlen($clave) > 1) {
            return strtoupper($clave[0]) .
                strtolower(substr($clave, 1, -1)) .
                strtoupper(substr($clave, -1));
        }
        return strtoupper($clave);
    }

    public function next(): void
    {
        ++$this->_position;
    }

    public function rewind(): void
    {
        $this->_position = 0;
    }

    public function valid(): bool
    {
        return isset($this->_keys[$this->_position]);
    }
}
