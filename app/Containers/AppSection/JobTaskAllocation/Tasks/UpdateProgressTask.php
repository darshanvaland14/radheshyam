<?php

namespace App\Containers\AppSection\JobTaskAllocation\Tasks;

use App\Containers\AppSection\JobTaskAllocation\Data\Repositories\JobTaskAllocationRepository;
use App\Containers\AppSection\JobTaskAllocation\Models\CreateProgress;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Carbon\Carbon;

class UpdateProgressTask  extends ParentTask
{
    public function __construct(
        protected readonly JobTaskAllocationRepository $repository,
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */

     public function run($request)
     {
        // return "Task is running!";
         try {
            $id = $request->id;
            $pdate = Carbon::createFromFormat('d-m-Y', $request->pdate)->format('Y-m-d');    
            $ptime = Carbon::createFromFormat('d-m-Y', $request->ptime)->format('Y-m-d');
    
            $progress = CreateProgress::where("id" , $id)->first();
            $progress->jno = $request->jno; // Corrected format
            $progress->description = $request->description;
            $progress->userid = $request->userid;
            $progress->pdate = $pdate; // Corrected format
            $progress->ptime = $ptime; // Corrected format
            $progress->save();
    
            return [
                'result' => true,
                'message' => "Progress Updated Successfully",
            ];
         } catch (\Exception $e) {
             return [
                 'result' => false,
                 'message' => 'Error: ' . $e->getMessage(),
                 'object' => 'Progress',
                 'data' => [],
             ];
         }
     }

}
