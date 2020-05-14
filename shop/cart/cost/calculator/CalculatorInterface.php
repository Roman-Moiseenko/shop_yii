<?php


namespace shop\cart\cost\calculator;


use shop\cart\cost\Cost;

interface CalculatorInterface
{

    public function getCoast(array $items): Cost;
}