<?php

use Temporal\Samples\SimpleActivity\GreetingActivity;
use Temporal\Samples\SimpleActivity\GreetingWorkflow;
use Temporal\Testing\WorkerFactory;

$factory = WorkerFactory::create();

$worker = $factory->newWorker();
$worker->registerWorkflowTypes(GreetingWorkflow::class);
$worker->registerActivity(GreetingActivity::class);
$factory->run();