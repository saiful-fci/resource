<?php

namespace App\Http\Controllers;
use Validator;
use Auth;
use DB;
use App\Models\AcademicSession;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AcademicSessionRequest;
use App\Services\AcademicSessionService;
use App\Services\SetupService;
use App\Http\Controllers\Controller;

class SetupController extends Controller
{
    public function softwareSetup()
    {
        DB::table('academic_session')->where('session_name',2020)->delete();
        // DB::table('batch_info as bi')
        //     ->where('bi.status',0)
        //     ->update([
        //         'bi.new_admission_allow'=>1,
        //         'status'=>1
        //     ]);
        //     exit;
        $sessinId=SetupService::academicSessionCreate();
        $oldBatch=SetupService::oldBatchGetForProcess($sessinId);
        $newBatch=SetupService::newBatchCreate($oldBatch,$sessinId);
        echo "successful";
    }
}

    