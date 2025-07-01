<?php

namespace App\Containers\AppSection\JobTaskAllocation\Tasks;

use App\Containers\AppSection\JobTaskAllocation\Data\Repositories\JobTaskAllocationRepository;
use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
class UpdateJobTaskAllocationTask extends ParentTask
{
    public function __construct(
        protected readonly JobTaskAllocationRepository $repository,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($request)
    {

        try {
            $id = $request->srno;
            // Convert 'pdate' from 'd-m-Y' to 'Y-m-d'
            $pdate = Carbon::createFromFormat('d-m-Y', $request->pdate)->format('Y-m-d');
    
            // Convert 'jtime' from 'd-m-Y' to 'Y-m-d'
            $jtime = Carbon::createFromFormat('d-m-Y', $request->jtime)->format('Y-m-d');
    
            $jobtask = JobTaskAllocation::where("srno" , $id)->first();
            $jobtask->pdate = $pdate; // Corrected format
            $jobtask->descri = $request->descri;
            $jobtask->jtype = $request->jtype;
            $jobtask->jtime = $jtime; // Corrected format
            $jobtask->days = $request->days;
            $jobtask->dayofweek = $request->dayofweek;
            $jobtask->allotto = $request->allotto;
            $jobtask->userid = $request->userid;
            $jobtask->ojobno = $request->ojobno;
            $jobtask->ouserid = $request->ouserid;
            $jobtask->status = $request->status;
            $jobtask->allocationno = $request->allocationno;
            $jobtask->title = $request->title;
            $jobtask->priority = $request->priority;
            $jobtask->save();
    
            return [
                'result' => true,
                'message' => "Job Task Allocation Updated Successfully",
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'object' => 'Job Task Allocation',
                'data' => [],
            ];
        }
       
    }
   
}
