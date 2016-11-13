<?php

/**
 * @author Patrick Beckedorf
 * Prevent foreign key constraints to block tests and their fixtures
 */

require __DIR__.'/app/autoload.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArrayInput;

$kernel = new AppKernel('test', true); // create a "test" kernel
$kernel->boot();
$application = new Application($kernel);
$application->setAutoExit(false);

$db_drop = new ArrayInput(array(
    'command' => 'doctrine:schema:drop',
    '--env' => 'test',
    '--force' => true
));
$application->run($db_drop, new ConsoleOutput());

$db_create = new ArrayInput(array(
    'command' => 'doctrine:schema:update',
    '--env' => 'test',
    '--force' => true
));
$application->run($db_create, new ConsoleOutput());

/* add testdata / fixtures here */