<?php

namespace Tests\Unit\Services\Communication\Receivers;

use PHPUnit\Framework\TestCase;
use App\Services\Communication\Receivers\AbstractReceiver;
use App\Services\Communication\Receivers\ReceiverInterface;
use App\Services\Communication\Sender\SenderInterface;
use App\Services\Communication\Mapping\MappingInterface;

class AbstractReceiverTest extends TestCase
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
        
        $this->receiver = new class ($this->senderMock,$this->mapperMock)
            extends AbstractReceiver 
        {
            protected function normalizeResult(array $resp): array
            {
                return $resp;
            }
        };
        
    }
    
    /**
     * @test
     * @testdox AbstractReceiver::class implements ReceiverInterface .
     */
    public function implementsInterface(): void
    {
        $int = class_implements(AbstractReceiver::class, true) ?? [];

        $this->assertContains(ReceiverInterface::class, $int);
    }

    /**
     * @test
     * @testdox If sender throws Exception, should get empty result.
     */
    public function senderThrowsException(): void
    {
        $this->senderMock
            ->expects($this->once())
            ->method('get')
            ->will(
                $this->returnCallback(
                    function () {
                                throw new \InvalidArgumentException('test');
                    }
                )
            );

        $resp = $this->receiver->fetch();

        $this->assertIsArray($resp);
        $this->assertEmpty($resp);
    }

    
    /**
     * @test
     * @testdox If normalizeResult throws exception we should receive empty result.
     */
    public function normalizeResultThrowsException(): void
    {
        $this->receiver = new class ($this->senderMock,$this->mapperMock)
            extends AbstractReceiver {
            protected function normalizeResult(array $resp): array 
            {
                throw new \InvalidArgumentException('Invalid resp.');
            }
        };
        $this->senderMock
            ->expects($this->once())
            ->method('get')
            ->willReturn(['status' => 'ok']);

    
        $resp = $this->receiver->fetch();

        $this->assertIsArray($resp);
        $this->assertEmpty($resp);
    }
}
