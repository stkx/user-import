<?php
declare(strict_types=1);

namespace App\Common\Event;

interface ListenerInterface
{
    public function isSupports(EventInterface $event): bool;

    public function process(EventInterface $event): void;
}
