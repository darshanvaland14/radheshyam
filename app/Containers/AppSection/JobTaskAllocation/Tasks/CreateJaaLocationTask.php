<?php

namespace App\Containers\AppSection\JobTaskAllocation\Tasks;

use App\Containers\AppSection\JobTaskAllocation\Data\Repositories\JobTaskAllocationRepository;
use App\Containers\AppSection\JobTaskAllocation\Models\JaaLocation;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Carbon\Carbon;

class CreateJaaLocationTask extends ParentTask
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
        // return "task running";
        
        try {
        
             // Convert 'pdate' from 'd-m-Y' to 'Y-m-d'
            $adate = Carbon::createFromFormat('d-m-Y', $request->adate)->format('Y-m-d');
            $jodate = Carbon::createFromFormat('d-m-Y', $request->jodate)->format('Y-m-d');
            $compdate=carbon::createFromFormat('d-m-Y', $request->compdate)->format('Y-m-d');
            $jdate=Carbon::createFromFormat('d-m-Y', $request->jdate)->format('Y-m-d');
             // Convert 'jtime' from 'd-m-Y' to 'Y-m-d'
            $jotime = Carbon::createFromFormat('d-m-Y', $request->jotime)->format('Y-m-d');
            
             $jobtask = new JaaLocation;    
             $jobtask->adate = $adate; 
             $jobtask->jno = $request->jno; // Corrected format
             $jobtask->allotto = $request->allotto;
             $jobtask->givenby = $request->givenby;
             $jobtask->jodate = $jodate; // Corrected format
             $jobtask->jotime = $jotime;
             $jobtask->status = $request->status;
             $jobtask->forwardno = $request->forwardno;
             $jobtask->compdate = $compdate;
             $jobtask->forwardto = $request->forwardto;
             $jobtask->ojobno = $request->ojobno;
             $jobtask->conf = $request->conf;
             $jobtask->jdate = $jdate;
             $jobtask->save();
     
             return [
                 'result' => true,
                 'message' => "Jaa Location Created Successfully",
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
