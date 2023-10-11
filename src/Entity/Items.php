<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ItemsRepository;

/**
 * Items
 *
 * @ORM\Table(name="items", uniqueConstraints={@ORM\UniqueConstraint(name="codeindex", columns={"code"})})
 * @ORM\Entity(repositoryClass="App\Repository\ItemsRepository")
 */
class Items
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=512, nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="bigint", nullable=false, options={"unsigned"=true})
     */
    //#[ORM\Column(name: 'code', type: 'bigint', nullable: false, unique: true, options: ['unsigned': true])]
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="weight", type="decimal", precision=12, scale=3, nullable=true)
     */
    private $weight;

    /**
     * @var string|null
     *
     * @ORM\Column(name="usagetxt", type="text", length=65535, nullable=true)
     */
    private $usagetxt;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_1", type="integer", nullable=false)
     */
    private $quantity1 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_2", type="integer", nullable=false)
     */
    private $quantity2 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_3", type="integer", nullable=false)
     */
    private $quantity3 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_4", type="integer", nullable=false)
     */
    private $quantity4 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_5", type="integer", nullable=false)
     */
    private $quantity5 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_6", type="integer", nullable=false)
     */
    private $quantity6 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_7", type="integer", nullable=false)
     */
    private $quantity7 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_8", type="integer", nullable=false)
     */
    private $quantity8 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_1", type="integer", nullable=false)
     */
    private $price1 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_2", type="integer", nullable=false)
     */
    private $price2 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_3", type="integer", nullable=false)
     */
    private $price3 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_4", type="integer", nullable=false)
     */
    private $price4 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_5", type="integer", nullable=false)
     */
    private $price5 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_6", type="integer", nullable=false)
     */
    private $price6 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_7", type="integer", nullable=false)
     */
    private $price7 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="price_8", type="integer", nullable=false)
     */
    private $price8 = '0';

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function getUsagetxt(): ?string
    {
        return $this->usagetxt;
    }

    public function getQuantity1(): int|string
    {
        return $this->quantity1;
    }

    public function getQuantity2(): int|string
    {
        return $this->quantity2;
    }

    public function getQuantity3(): int|string
    {
        return $this->quantity3;
    }

    public function getQuantity4(): int|string
    {
        return $this->quantity4;
    }

    public function getQuantity5(): int|string
    {
        return $this->quantity5;
    }

    public function getQuantity6(): int|string
    {
        return $this->quantity6;
    }

    public function getQuantity7(): int|string
    {
        return $this->quantity7;
    }

    public function getQuantity8(): int|string
    {
        return $this->quantity8;
    }

    public function getPrice1(): int|string
    {
        return $this->price1;
    }

    public function getPrice2(): int|string
    {
        return $this->price2;
    }

    public function getPrice3(): int|string
    {
        return $this->price3;
    }

    public function getPrice4(): int|string
    {
        return $this->price4;
    }

    public function getPrice5(): int|string
    {
        return $this->price5;
    }

    public function getPrice6(): int|string
    {
        return $this->price6;
    }

    public function getPrice7(): int|string
    {
        return $this->price7;
    }

    public function getPrice8(): int|string
    {
        return $this->price8;
    }



}
