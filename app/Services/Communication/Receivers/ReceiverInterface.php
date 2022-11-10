<?php

namespace App\Services\Communication\Receivers;

interface ReceiverInterface
{
    public function fetch(): array;
}
