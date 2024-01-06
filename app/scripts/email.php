<?php

declare(strict_types=1);

use Synthex\Phptherightway\Core\App;
use Synthex\Phptherightway\Core\Container;
use Synthex\Phptherightway\Services\EmailService;

require_once __DIR__ . '/../../vendor/autoload.php';

$container = new Container();

(new App($container))->boot();

$container->get(EmailService::class)->sendQueuedEmails();
