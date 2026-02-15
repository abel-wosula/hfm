<?php

namespace App\GraphQL\Queries;

use App\Models\HomepageSection;

class HomepageSectionQuery
{
    public function fetchHomepageSections($_, $args)
    {
        $events = HomepageSection::query()
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->get(); // Fetch the events

        return $events;
    }
}
