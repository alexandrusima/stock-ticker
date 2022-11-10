<?php

namespace Tests\Feature\Communcation;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use App\Services\Communication\Receivers\CompaniesReceiverInterface;

class CompaniesReceiverTest extends TestCase
{
    private ?CompaniesReceiverInterface $receiver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->receiver = $this->app->get(CompaniesReceiverInterface::class);
    }

    /**
     * @test
     * @testdox Getting results from CompanyReceiver  app container works.
     */
    public function itWorks()
    {
        $response = $this->receiver->fetch();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);

        $json = json_encode($response, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

        $testResponse = new TestResponse(new Response($json));
        $testResponse->assertJsonStructure(
            [
            [
                'name',
                'symbol'
            ]
            ]
        );
    }
}
