<?php

namespace Tests\Unit\Services\Communication\Sender;

use PHPUnit\Framework\TestCase;
use App\Services\Communication\Sender\Sender;
use App\Services\Communication\Sender\SenderInterface;
use App\Services\Communication\Connection\Connection;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class SenderTest extends TestCase
{
    /**
     * @var Sender|MockObject
     */
    private $sender;

    /**
     * @var Client|MockObject
     */
    private $client;

    protected function setUp(): void
    {

        $url = 'http://localhost:999';
    
        $connection = $this->createMock(Connection::class);

        $connection
             ->expects($this->atLeastOnce())
            ->method('getUrl')
            ->willReturn($url);

        $connection->expects($this->atLeastOnce())
            ->method('getHeaders')
            ->willReturn([]);

        $respMock = $this->getMockBuilder(ResponseInterface::class)
                   ->disableOriginalConstructor()
                   ->getMock();

        $this->client = $this->createMock(Client::class);

        $this->client
         ->expects($this->once())
         ->method('request')
         ->with('GET', $url, [])
        ->will(
            $this->returnCallback(
                function () use ($respMock) { 
                         return $respMock;
                }
            )
        );
        
        $this->sender = new Sender($connection, $this->client);
    }

    /**
     * @test
     * @testdox Using Sender::get() calls underlying guzzle client.
     */
    public function success()
    {
        $resp = $this->sender->get();

        $this->assertInstanceOf(SenderInterface::class, $this->sender);
        $this->assertInstanceOf(ResponseInterface::class, $resp);
    }

    /**
     * @test
     * @testdox If guzzle throws exception Sender::get() throws exception. 
     */
    public function error()
    {
        $this->client
        ->method('request')
        ->will(
            $this->returnCallback(
                function () {
                      throw new \RuntimeException('test');
                }
            )
        );
        $this->expectException(\RuntimeException::class);
        $this->sender->get();
    }
}
