<?php

namespace Tests\Feature\Communcation;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use App\Services\Communication\Receivers\TickerReceiverInterface;

class TickerReceiverTest extends TestCase
{
    private ?TickerReceiverInterface $receiver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->receiver = $this->app->get(TickerReceiverInterface::class);
    }

    /**
     * @test
     * @testdox Getting Results from app container works.
     */
    public function itWorks()
    {
        $response = $this->receiver->fetch(
            [
                'symbol' => 'GOOG',
                'region' => 'US',
                'startDate' => (new \DateTime('-1 minute'))->getTimestamp(),
                'endDate' => (new \DateTime('+3 minute'))->getTimestamp()
            ]
        );

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);

        $json = json_encode($response, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

        $testResponse = new TestResponse(new Response($json));
        $testResponse->assertJsonStructure(
            [
                [
                    'date',
                    'o',
                    'h',
                    'l',
                    'c',
                    'volume',
                    'adjclose',
                ]
            ]
        );
    }
}
