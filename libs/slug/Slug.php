<?php

namespace Libs\Slug;

trait Slug
{
    public function slug(string $toSlug): string
    {
        return str_replace(' ', '-', mb_convert_case($toSlug, MB_CASE_LOWER));
    }
}
