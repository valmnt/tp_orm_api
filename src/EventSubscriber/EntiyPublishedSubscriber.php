<?php

namespace App\EventSubscriber;

use App\Article\Status;
use App\Entity\Article;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class EntityPublishedSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate
        ];
    }

    public function preUpdate(LifecycleEventArgs $lifecycleEventArgs)
    {
        $object = $lifecycleEventArgs->getObject();

        if ($object instanceof Article) {
            if ($object->getStatus() === Status::published) {
                $object->setPublished(new DateTime());
            }
        }
    }
}
