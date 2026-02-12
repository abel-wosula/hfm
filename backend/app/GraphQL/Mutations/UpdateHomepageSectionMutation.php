<?php

namespace App\GraphQL\Mutations;

use App\Models\HomepageSection;

class UpdateHomepageSectionMutation
{
    public function updateHomepageSection($_, array $args)
    {
        $homepage_section = HomepageSection::find($args['key']);
        if (!$homepage_section) {
            return [
                'message' => 'Homepage section not found',
                'homepage_section' => null,
            ];
        }

        $homepage_section->update($args['input']);

        return [
            'message' => 'Homepage section updated successfully!',
            'homepage_section' => $homepage_section,
        ];
    }
}
