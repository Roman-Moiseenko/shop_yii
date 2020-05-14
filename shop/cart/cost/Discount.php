<?php


namespace shop\cart\cost;


class Discount
{

    /**
     * @var float
     */
    private $value;
    /**
     * @var string
     */
    private $name;
    //Абсолютная (руб) или Относительная (%)
    private $absolute;

    public function __construct(float $value, string $name, bool $absolute = true)
    {
        $this->value = $value;
        $this->name = $name;
        $this->absolute = $absolute;
    }

    public function isAbsolute()
    {
        return $this->absolute;
    }
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getString(): string
    {
        if ($this->isAbsolute()) {
            return $this->value . ' руб.';
        } else {
            return $this->value . ' %';
        }
    }
}