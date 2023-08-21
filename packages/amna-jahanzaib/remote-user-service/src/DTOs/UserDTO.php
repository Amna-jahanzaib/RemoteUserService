<?php

namespace AmnaJahanzaib\RemoteUserService\DTOs;

use Illuminate\Contracts\Support\Arrayable;

class UserDTO implements Arrayable, \JsonSerializable
{
    protected $id;
    protected $first_name;
    protected $last_name;

    public function __construct($id, $first_name, $last_name)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }

    public static function fromArray(array $data)
    {
        return new self($data['id'], $data['first_name'], $data['last_name']);
    }
    
}
