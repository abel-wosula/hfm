<?php

namespace App\GraphQL\Mutations;

use App\Models\HomepageSection;

class CreateHomepageSectionMutation{
    public function createHomepageSection($_, $args)
    {
        $homepage_section = new HomepageSection();
        $homepage_section->key = $args['key'];
        $homepage_section->type = $args['type'];
        $homepage_section->title = $args['title'];
        $homepage_section->subtitle = $args['subtitle'];
        $homepage_section->content = $args['content'];
        $homepage_section->background_color = $args['background_color'];
        $homepage_section->text_align = $args['text_align'];
        $homepage_section->button_text = $args['button_text'];
        $homepage_section->button_link = $args['button_link'];
        $homepage_section->button_secondary_text = $args['button_secondary_text'];
        $homepage_section->button_secondary_link = $args['button_secondary_link'];
        $homepage_section->order = 0;
        $homepage_section->is_active = true;
        $homepage_section->save();

        return [
            'message' => 'Homepage section created successfully!',
            'homepage_section' => $homepage_section,
        ];
    }
}
