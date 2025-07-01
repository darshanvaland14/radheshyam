<?php

namespace App\Containers\AppSection\JobTaskAllocation\UI\API\Transformers;

use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class JobTaskAllocationTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(JobTaskAllocation $jobtaskallocation): array
    {
echo "hiiiii";
die;
        return [
            'srno' => $jobtaskallocation->getHashedKey(),
            // 'name' => $jobtaskallocation->name,
             'status' => $jobtaskallocation->status,
        ];
        // $response = [
        //     'object' => $jobtaskallocation->getResourceKey(),
        //     'id' => $jobtaskallocation->getHashedKey(),
          
        // ];
 
        // return $this->ifAdmin([
        //     'real_id' => $jobtaskallocation->id,
        //     'created_at' => $jobtaskallocation->created_at,
        //     'updated_at' => $jobtaskallocation->updated_at,
        //     'readable_created_at' => $jobtaskallocation->created_at->diffForHumans(),
        //     'readable_updated_at' => $jobtaskallocation->updated_at->diffForHumans(),
        //     // 'deleted_at' => $jobtaskallocation->deleted_at,
        // ], $response);
    }
}
