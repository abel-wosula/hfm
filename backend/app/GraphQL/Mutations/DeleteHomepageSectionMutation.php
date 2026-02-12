<?php

namespace App\GraphQL\Mutations;

use App\Models\HomepageSection;

class DeleteHomepageSectionMutation
{
    public function deleteHomepageSection($_, array $args)
    {
        $homepage_section = HomepageSection::find($args['key']);

        if (!$homepage_section) {
            return [
                'message' => 'Homepage section not found',
                'homepage_section' => null,
            ];
        }

        $homepage_section->delete();
        return [
            'message' => 'Homepage section deleted successfully',
            'homepage_section' => $homepage_section,
        ];
    }
}
