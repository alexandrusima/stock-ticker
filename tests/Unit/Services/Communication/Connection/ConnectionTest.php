<?php

namespace Tests\Unit\Services\Communication\Connection;

use PHPUnit\Framework\TestCase;
use App\Services\Communication\Connection\Connection;
use App\Services\Communication\Connection\ConnectionInterface;

class ConnectionTest extends TestCase
{
    /**
     * @test
     * @testdox Connection::class implements ConnectionInterface .
     */
    public function implementsInterface(): void
    {
        $int = class_implements(Connection::class, true) ?? [];

        $this->assertContains(ConnectionInterface::class, $int);
    }

    /**
     * @test
     * @testdox not passing any params retuns as expected
     */
    public function noConfigureRetunsExpected(): void
    {
        $connection = new Connection();

        $this->assertNull($connection->getUrl());
        $this->assertTrue(is_array($connection->getHeaders()));
        $this->assertEmpty($connection->getHeaders());
    }

    
    /**
     * @test
     * @testdox configured retuns as expected
     */
    public function configureRetunsExpected(): void
    {
        $connection = new Connection();
        $connection->setUrl('http://google.ro');

        $retVal = $connection->addHeaders(
            [
            'Content-Type' => 'application/json'
            ]
        );

        $aRetVal = $connection->addHeader('Accept', 'jpg');

        $this->assertInstanceOf(ConnectionInterface::class, $retVal);
        $this->assertInstanceOf(ConnectionInterface::class, $aRetVal);

        $this->assertEquals('http://google.ro', $connection->getUrl());

        $headers = $connection->getHeaders();
        
        $this->assertTrue(is_array($headers));
        $this->assertNotEmpty($headers);
        $this->assertContains('jpg', $headers);
        $this->assertContains('application/json', $headers);
        
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertArrayHasKey('Accept', $headers);
    
    }
}
