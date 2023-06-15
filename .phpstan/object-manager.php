<?php
declare(strict_types=1);

use App\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel('dev', true);
putenv('DATABASE_URL=mysql://localhost');
$kernel->boot();
return $kernel->getContainer()->get('doctrine')->getManager();
