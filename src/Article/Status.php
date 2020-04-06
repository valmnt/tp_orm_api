<?php

namespace App\Article;

class Status
{
    const  notPublished = 0;
    const  draft = 1;
    const  published = 2;

    public static function getStatus()
    {
        return [
            self::notPublished,
            self::draft,
            self::published
        ];
    }
}
