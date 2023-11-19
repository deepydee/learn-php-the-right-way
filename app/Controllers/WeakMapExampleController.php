<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Entities\Invoice;

class WeakMapExampleController
{
    public function __construct(private Invoice $invoice)
    {
    }

    public function index()
    {
        // $storage = new \SplObjectStorage(); // hardmap - hard reference to the object
        $map = new \WeakMap();

        // $storage[$this->invoice] = 123;
        $map[$this->invoice] = ['foo' => 'bar'];

        // var_dump(count($storage));
        var_dump(count($map));
        var_dump($map);

        unset($this->invoice);

        // var_dump(count($storage));
        var_dump($map);
        var_dump(count($map));
    }
}
