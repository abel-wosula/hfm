<?php

namespace App\GraphQL\Mutations;

use App\Models\Service;

class DeleteServiceMutation
{
    public function deleteService($_, array $args)
    {
        $service = Service::find($args['id']);

        if (!$service) {
            return [
                'message' => 'Service not found',
                'service' => null,
            ];
        }

        $service->delete();

        return [
            'message' => 'Service deleted successfully',
            'service' => $service,
        ];
    }
}
