<?php

namespace App\EventSubscriber;

use App\Article\Status;
use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class EntityCreatedSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $lifecycleEventArgs)
    {
        $object = $lifecycleEventArgs->getObject();

        if ($object instanceof Article || $object instanceof Category) {
            $object->setCreated(new DateTime());
        }

        if ($object instanceof Article) {
            $object->setStatus(Status::draft);
        }
    }
}
