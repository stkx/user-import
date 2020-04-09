<?php
declare(strict_types=1);

namespace App\Common\Event;

class Dispatcher
{
    /**
     * @var ListenerInterface[]
     */
    private array $listeners;

    public function dispatchEvent(EventInterface $event)
    {
        foreach ($this->listeners as $listener) {
            if ($listener->isSupports($event)) {
                $listener->process($event);
            }
        }
    }

    public function registerListener(ListenerInterface $listener)
    {
        $this->listeners[] = $listener;
    }
}
