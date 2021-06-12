<?php
declare(strict_types=1);

namespace App;


final class Events
{
    public const LOOP_START = 'loop.start';
    public const LOOP_CANCEL = 'loop.cancel';

    public const CRAWLER_BEGIN = 'crawler.begin';
    public const CRAWLER_FINISH = 'crawler.finish';
}