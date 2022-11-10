<?php

namespace Tests\Unit\Services\Communication\Receivers;

use PHPUnit\Framework\TestCase;
use App\Services\Communication\Receivers\AbstractReceiver;
use App\Services\Communication\Receivers\CompaniesReceiver;
use App\Services\Communication\Receivers\ReceiverInterface;
use App\Services\Communication\Sender\SenderInterface;
use App\Services\Communication\Mapping\MappingInterface;

class CompaniesReceiverTest extends TestCase
{
    /**
     * @var ReceiverInterface
     */
    private $receiver;

    private $senderMock;
    private $mapperMock;

    protected function setUp(): void
    {
        $this->senderMock = $this->getMockBuilder(SenderInterface::class)
                           ->disableOriginalConstructor()
                           ->getMock();
        
        $this->mapperMock = $this->getMockBuilder(MappingInterface::class)
                           ->disableOriginalConstructor()
                           ->getMock();
        
        $this->receiver = new CompaniesReceiver($this->senderMock, $this->mapperMock);
        
    }
    
    /**
     * @test
     * @testdox Implements AbstractReceiver::class and ReceiverInterface .
     */
    public function implementsAndExtendsInterface(): void
    {

        $this->assertInstanceOf(ReceiverInterface::class, $this->receiver);
        $this->assertInstanceOf(AbstractReceiver::class, $this->receiver);
    }

    /**
     * @test
     * @testdox If mapper throws exception we get empty result.
     */
    public function mapperThrowsException(): void
    {
        $this->mapperMock->expects($this->atLeastOnce())
               ->method('map')
            ->will(
                $this->returnCallback(
                    function () {
                               throw new \Exception('good for testing');
                    }
                )
            );

        $this->senderMock->expects($this->atLeastOnce())
                   ->method('get')
               ->willReturn(['ok' => [ true ]]);

        $resp = $this->receiver->fetch();

        $this->assertIsArray($resp);
        $this->assertEmpty($resp);
    }
}
