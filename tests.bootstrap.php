<?php

require __DIR__.'/app/autoload.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

$kernel = new AppKernel('test', true); // create a "test" kernel
$kernel->boot();
$application = new Application($kernel);
$application->setAutoExit(false);

// Purge database
$purger = new ORMPurger($kernel->getContainer()->get('doctrine')->getManager());
$purger->purge();