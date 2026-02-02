<?php

namespace App\GraphQL\Mutations;

use App\Models\Service;

class UpdateServiceMutation
{
    public function updateService($_, array $args)
    {
        $service = Service::find($args['id']);
        if (!$service) {
            return [
                'message' => 'Service not found',
                'service' => null,
            ];
        }

        $service->update($args['input']);

        return [
            'message' => 'Service updated successfully!',
            'service' => $service,
        ];
    }
}
