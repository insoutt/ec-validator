<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\EcValidator;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_main()
    {
        $validator = new EcValidator();
        $this->assertSame($validator->main(1), 1);
    }
}
