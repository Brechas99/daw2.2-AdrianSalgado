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

class Usuario extends Dato
{
    use Identificable;

    private string $identificador;
    private string $contrasenna;
    private ?string $codigoCookie;
    private ?string $caducidadCodigoCookie;
    private int $tipoUsuario;
    private String $nombre;
    private string $apellidos;

    public function __construct(int $id, string $identificador, string $contrasenna, string $codigoCookie, string $caducidadCodigoCookie, int $tipoUsuario, string $nombre, string $apellidos)
    {
        $this->setId($id);
        $this->setIdentificador($identificador);
        $this->setContrasenna($contrasenna);
        $this->setCodigoCookie($codigoCookie);
        $this->setCaducidadCodigoCookie($caducidadCodigoCookie);
        $this->setTipoUsuario($tipoUsuario);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }
    public function setIdentificador(string $identificador)
    {
        $this->identificador = $identificador;
    }

    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }
    public function setContrasenna(string $contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }

    public function getCodigoCookie(): ?string
    {
        return $this->codigoCookie;
    }
    public function setCodigoCookie($codigoCookie)
    {
        $this->codigoCookie = $codigoCookie;
    }

    public function getCaducidadCodigoCookie(): string
    {
        return $this->caducidadCodigoCookie;
    }
    public function setCaducidadCodigoCookie($caducidadCodigoCookie)
    {
        $this->codigoCookie = $caducidadCodigoCookie;
    }

    public function getTipoUsuario(): int
    {
        return $this->tipoUsuario;
    }
    public function setTipoUsuario(int $tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }
    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

}

class Publicacion extends Dato
{
    use Identificable;

    private string $fecha;
    private int $emisorId;
    private  $destinatarioId;
    private  $destacadaHasta;
    private String $asunto;
    private string $contenido;

    public function __construct(int $id, string $fecha, int $emisorId,   $destinatarioId,   $destacadaHasta, string $asunto, string $contenido)
    {
        $this->setId($id);
        $this->setFecha($fecha);
        $this->setEmisorId($emisorId);
        $this->setDestinatarioId($destinatarioId);
        $this->setDestacadoHasta($destacadaHasta);
        $this->setAsunto($asunto);
        $this->setContenido($contenido);
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }
    public function setFecha(string $fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEmisorId(): int
    {
        return $this->emisorId;
    }
    public function setEmisorId(string $emisorId)
    {
        $this->emisorId = $emisorId;
    }

    public function getDestinatarioId(): ?int
    {
        return $this->destinatarioId;
    }
    public function setDestinatarioId($destinatarioId)
    {
        $this->destinatarioId = $destinatarioId;
    }

    public function getDestacadoHasta(): ?string
    {
        return $this->destacadoHasta;
    }
    public function setDestacadoHasta($destacadaHasta)
    {
        $this->destacadoHasta = $destacadaHasta;
    }

    public function getAsunto(): string
    {
        return $this->asunto;
    }
    public function setAsunto(string $asunto)
    {
        $this->asunto = $asunto;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }
    public function setContenido(string $contenido)
    {
        $this->contenido = $contenido;
    }

}
