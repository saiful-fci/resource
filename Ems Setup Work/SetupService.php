<?php
namespace App\Services;

/*Model*/
use App\Models\ClassName;

use Auth;
use Session;
use Lang;
use DB;

class SetupService
{
    public static function academicSessionCreate()
    {
        $result=DB::table('academic_session')
        ->insertGetId([
            'session_name'=>date('Y'),
            'session_start_date'=>date('Y-01-01'),
            'session_end_date'=>date('Y-12-31'),
            'status'=>1,
            'created_at'=>date('Y-m-d'),
            'updated_at'=>date('Y-m-d'),
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id
        ]);
        return $result;
    }
    public static function oldBatchGetForProcess($sessinId=null)
    {
        return DB::table('batch_info as bi')
                ->where('bi.status',1)
                ->get();
    }
    public static function newBatchCreate($oldBatch=null,$sessinId=null)
    {
        $last_batch_id=0;
        foreach ($oldBatch as $key => $value) {
            $result=explode('-', $value->batch_name);
            if($result[0]=="Play"|| $result[0]=="Nursery" || $result[0]=="One"|| $result[0]=="Two"|| $result[0]=="Three"|| $result[0]=="Four" || $result[0]=="Five"|| $result[0]=="Six" || $result[0]=="Seven"|| $result[0]=="Eight" || $result[0]=="Nine"|| $result[0]=="Ten")
            {
            $batchId=DB::table('batch_info')
            ->insertGetId([
                'batch_name'=>$result[0].'-'.$result[1].'-'.date('Y'),
                'batch_no'=>$value->batch_no+1,
                'fk_class_wise_group_setup_id'=>$value->fk_class_wise_group_setup_id,
                'fk_academic_session_id'=>$sessinId,
                'fk_syllabus_id'=>$value->fk_syllabus_id,
                'new_admission_allow'=>1,
                'status'=>1,
                'created_at'=>date('Y-m-d'),
                'updated_at'=>date('Y-m-d'),
                'created_by'=>Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);

            DB::table('batch_info as bi')
            ->where('bi.id',$value->id)
            ->update([
                'bi.new_admission_allow'=>0,
                'status'=>0
            ]);
            $last_batch_id=$value->id;

            DB::table('batch_wise_shift')
            ->insertGetId([
                'fk_batch_id'=>$batchId,
                'fk_shift_id'=>1,
                'created_at'=>date('Y-m-d'),
                'updated_at'=>date('Y-m-d'),
                'created_by'=>Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);

            }else{
                break;
            }
        }
        $new_batch_wise_shift=DB::table('batch_wise_shift')
        ->where('fk_batch_id','>',$last_batch_id)
        ->get(['id']);
        
        $status=self::sectionCreate($new_batch_wise_shift);
        return $status;          
    }
    public static function sectionCreate($new_batch_wise_shift)
    {
        foreach ($new_batch_wise_shift as $key => $value) {
            $batchWiseShiftId[]=$value->id;
        }
        $oldSection=DB::table('cc_section_setup')
                    ->where('status',1)
                    ->get();
        foreach ($oldSection as $key => $value) {
            DB::table('cc_section_setup')
            ->insert([
                'section_name'=>$value->section_name,
                'fk_branch_id'=>Session::get('user.current_branch_id'),
                'fk_batch_wise_shift_id'=>$batchWiseShiftId[$key],
                'fk_scheme_master_id'=>$value->fk_scheme_master_id,
                'capacity'=>$value->capacity,
                'status'=>1,
                'created_at'=>date('Y-m-d'),
                'updated_at'=>date('Y-m-d'),
                'created_by'=>Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);
            DB::table('cc_section_setup as cs')
            ->where('cs.id',$value->id)
            ->update(['status'=>0]);
        }
    }  

}
