<?php

enum EstadoCivil: int
{
    case Soltero = 10;
    case Casado = 20;
    case Pareja = 30;
    case Viudo = 40;

    function descripcion(): string
    {
        return $this->name;
    }

    function valor(): int
    {
        return $this->value;
    }

    static function metodoEstatico(): array
    {
        return EstadoCivil::cases();
    }
}
