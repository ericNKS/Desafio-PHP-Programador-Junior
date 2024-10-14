<?php
namespace App\Model;

class Produto
{
    private $id;
    private string $name;
    private string $description;
    private float $price;
    private $created_at;

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getName(): string{
        return $this->name;
    }
    
    public function setName(string $name){
        $this->name = $name;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function getPrice(): float{
        return $this->price;
    }

    public function setPrice(float $price){
        if($price <= 0){
            throw new \Exception("price cannot be 0 or less than 0");
        }
        $this->price = $price;
    }

    public function getCreatedAt(): string{
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at){
        $this->created_at = $created_at;
    }

}