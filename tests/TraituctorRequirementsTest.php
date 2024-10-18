<?php declare(strict_types=1);

use Nabeghe\Traituctor\Traituctor;
use Nabeghe\Traituctor\Requirements;

class TraituctorRequirementsTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->assertSame(182, (new Main(10))->multiply());
    }
}

#[Requirements(B::class)]
trait A
{
    protected $numberA;

    public function __constructA($baseNumber)
    {
        $this->numberA = $this->numberB + 1;
    }
}

trait B
{
    protected $numberB;

    public function __constructB($baseNumber)
    {
        $this->numberB = $baseNumber + 3;
    }
}

class Main
{
    use A, B;

    public function __construct($baseNumber)
    {
        Traituctor::construct($this, [$baseNumber], true);
    }

    public function multiply()
    {
        return $this->numberA * $this->numberB;
    }
}