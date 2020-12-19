<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function verifyCode(Request $request){

        //DB query to check verification code based on expire time & redeem status.

        $dateNow = Carbon::now();

        $matchThese = ['firstName' => $request['student_firstName'], 'lastName' => $request['student_lastName']];
        $student_id = Student::select('student_id')->where($matchThese)->get();


        //$matchThese = ['student_id' => $student_id[0]['student_id'], 'redeemed' => false , 'vc' => $request['v_code']];
        
        if($verificationCodeQuery = Verification::where('student_id', $student_id[0]['student_id'])->get()) {
            
            if($verificationCodeQuery[0]['vc'] === intval($request['v_code'])) {

                //Verification code is not redeemed yet
                if($verificationCodeQuery[0]['expiresAt'] > $dateNow) {
    
                    //Verification code is not expired. 
                    if($verificationCodeQuery[0]['redeemed'] === 0) {
    
                        //Verification code is correct. Success code = 1.
                        
                        //Set redeemed status on 1.
                        //Verification::select('vc_id')->where('vc', $request['v_code'])->update(['redeemed' => 1]);

                        //Delete verification code.
                        $vc_id=Verification::select('vc_id')->where('vc', $request['v_code'])->get();
                        Verification::where('vc_id', $vc_id[0]['vc_id'])->delete();


                        return response(1);
                    }
                    else {
                        //Verification code has already been redeemed or verificaiton code is not correct. Error code = 0.
                            return response(0);
                    }
                }
                else {
                    //Verification code is expired. Code error = 3.
                    return response(3);
                }
            }
            else {
                
                //If Wrong password, counter + 1  in DB.
                Verification::where('student_id', $student_id[0]['student_id'])->update(['passCounter' => DB::raw('passCounter + 1')]);

                //Check if counter >= 3. If yes, user hasRight = 0 and can not take an appointment.
                if(Verification::select('passCounter')->where('student_id', $student_id[0]['student_id'])->get()[0]['passCounter'] >= 3) {

                    //Change students' hasRight to false.
                    Student::where('student_id', $student_id[0]['student_id'])->update(['hasRight' => false]);

                    //Delete newly added verificaiton code of the DB since only one code per student is meant to be there.
                    Verification::where('student_id', $student_id[0]['student_id'])->delete();
                    return response(4);
                }
                else {
                    //Verification code is incorrect. Code error = 2.
                    
                }              
            }
            return response(2);
    
           //return response($verificationCodeQuery);
        }

        }
}
