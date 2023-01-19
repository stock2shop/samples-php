<?php

declare(strict_types=1);

namespace Temporal\Tests;

use PHPUnit\Framework\TestCase;
use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;
use Temporal\Samples\SimpleActivity\GreetingWorkflow;
use Temporal\Testing\ActivityMocker;

final class GreetingWorkflowTest extends TestCase
{
    private WorkflowClient $workflowClient;
    private ActivityMocker $activityMocks;

    protected function setUp(): void
    {
        $this->workflowClient = new WorkflowClient(ServiceClient::create('localhost:7233'));
        $this->activityMocks = new ActivityMocker();

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->activityMocks->clear();
        parent::tearDown();
    }

    public function testWorkflowReturnsUpperCasedInput(): void
    {
        $this->activityMocks->expectCompletion('SimpleActivity.ComposeGreeting', 'Hello world');
        $workflow = $this->workflowClient->newWorkflowStub(GreetingWorkflow::class);
        $run = $this->workflowClient->start($workflow, 'world');
        $result = $run->getResult();
        $this->assertSame('Hello world', $result);
    }
}