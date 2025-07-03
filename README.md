# Traituctor: Traits Pseudo-Constructor for PHP ≥ 7.4

> Invoking a pseudo constructor for each trait from within the main constructor.

Imagine a class uses multiple traits,
where each trait requires a method to be executed during the class's instantiation for initialization purposes.
Since in PHP only one trait added to a class can have a constructor, and others cannot,
one possible solution is to define initializtion methods in each trait
and manually call them within the main class constructor.
Another approach would be to check inside each trait’s method whether it has been initialized before executing it,
and then initialize it if necessary.

However, the current library handles this process automatically.
Here, you have a pseudo-constructor for each trait, and by invoking a method within the main class constructor,
all of them are executed in sequence.
Moreover, you can control the execution order by using an attribute called 'Requirements'.
This attribute allows you to define the dependencies between traits,
ensuring that the pseudo-constructor of a required trait is executed before its dependent trait.
Alternatively, you could omit this attribute and simply use the traits in the desired order in the main class,
but the attribute guarantees the correct sequence.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/traituctor
```

### Examples

#### Example - No Requirments:

```php
use Nabeghe\Traituctor\Traituctor;

trait A
{
    protected $numberA;

    public function __constructA($baseNumber)
    {
        echo "A\n";
        $this->numberA = $baseNumber + 3;
    }
}

trait B
{
    protected $numberB;

    public function __constructB($baseNumber)
    {
        echo "B\n";
        $this->numberB = $baseNumber + 4;
    }
}

class Main
{
    use A, B;

    public function __construct($baseNumber)
    {
        echo "Main\n";
        Traituctor::construct($this, [$baseNumber]);
    }

    public function multiply()
    {
        return $this->numberA * $this->numberB;
    }
}

echo (new Main(10))->multiply();

// Main
// A
// B
// 182
```

#### Example - Requirments:

**Notice:** Supported only in PHP 8 or higher.

```php
use Nabeghe\Traituctor\Traituctor;
use Nabeghe\Traituctor\Requirements;

#[Requirements(B::class)]
trait A
{
    protected $numberA;

    public function __constructA($baseNumber)
    {
        echo "A\n";
        $this->numberA = $this->numberB + 1;
    }
}

trait B
{
    protected $numberB;

    public function __constructB($baseNumber)
    {
        echo "B\n";
        $this->numberB = $baseNumber + 3;
    }
}

class Main
{
    use A, B;

    public function __construct($baseNumber)
    {
        echo "Main\n";
        Traituctor::construct($this, [$baseNumber], true);
    }

    public function multiply()
    {
        return $this->numberA * $this->numberB;
    }
}

echo (new Main(10))->multiply();

// Main
// B
// A
// 182
```

## 📖 License

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.