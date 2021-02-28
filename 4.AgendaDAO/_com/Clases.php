<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Categoria extends Dato
{
    use Identificable;

    private string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
}

class Persona extends Dato
{
    use Identificable;

    private string $nombre;
    private string $apellidos;
    private string $telefono;
    private int $estrella;
    private int $personaCategoriaId;

    public function __construct(int $id, string $nombre, string $apellidos, string $telefono,int $estrella, int $personaCategoriaId)
    {
        $this->setId($id);
        $this->setPersonaNombre($nombre);
        $this->setPersonaApellidos($apellidos);
        $this->setTelefono($telefono);
        $this->setEstrella($estrella);
        $this->setPersonaCategoriaId($personaCategoriaId);
    }

    public function getPersonaNombre(): string
    {
        return $this->nombre;
    }

    public function setPersonaNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getPersonaApellidos(): string
    {
        return $this->apellidos;
    }

    public function setPersonaApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono)
    {
        $this->telefono = $telefono;
    }

    public function getEstrella(): int
    {
        return $this->estrella;
    }

    public function setEstrella(int $estrella)
    {
        $this->estrella = $estrella;
    }

    public function getPersonaCategoriaId(): int
    {
        return $this->personaCategoriaId;
    }

    public function setPersonaCategoriaId(string $personaCategoriaId)
    {
        $this->personaCategoriaId = $personaCategoriaId;
    }

}