<?php

namespace system;

use App\Tools\AbstractKernelTestCase;

class SystemTest extends AbstractKernelTestCase
{
    public function testSomething(): void
    {
        // Test
        $this->assertTrue(true);
        $this->assertIsObject($this->entityManager);
    }
}