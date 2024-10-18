<?php declare(strict_types=1);

use Nabeghe\Traituctor\Traituctor;

class TraituctorNoRequirementsTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->assertSame(182, (new Main(10))->multiply());
    }
}

trait A
{
    protected $numberA;

    public function __constructA($baseNumber)
    {
        $this->numberA = $baseNumber + 3;
    }
}

trait B
{
    protected $numberB;

    public function __constructB($baseNumber)
    {
        $this->numberB = $baseNumber + 4;
    }
}

class Main
{
    use A, B;

    public function __construct($baseNumber)
    {
        Traituctor::construct($this, [$baseNumber]);
    }

    public function multiply()
    {
        return $this->numberA * $this->numberB;
    }
}