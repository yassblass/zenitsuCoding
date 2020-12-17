<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;
use Carbon\Carbon;
use App\Models\Student;

class StudentController extends Controller
{
    public function verifyCode(Request $request){

        //DB query to check verification code based on expire time & redeem status.

        $dateNow = Carbon::now();

        $matchThese = ['firstName' => $request['student_firstName'], 'lastName' => $request['student_lastName']];
        $student_id = Student::select('student_id')->where($matchThese)->get();


        $matchThese = ['student_id' => $student_id[0]['student_id'], 'redeemed' => false , 'vc' => $request['v_code']];
        
        if($verificationCodeQuery = Verification::where('student_id', $student_id[0]['student_id'])->get()) {
            
            if($verificationCodeQuery[0]['vc'] === intval($request['v_code'])) {

                //Verification code is not redeemed yet
                if($verificationCodeQuery[0]['expiresAt'] > $dateNow) {
    
                    //Verification code is not expired. 
                    if($verificationCodeQuery[0]['redeemed'] === 0) {
    
                        //Verification code is correct. Success code = 1.

                        $vcId = Verification::select('vc_id')->where('vc', $request['v_code'])->update(['redeemed' => 1]);
                        
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
                
                //Verification code is incorrect. Code error = 2.
                        return response(2);
            }
    
           //return response($verificationCodeQuery);
        }

        }
       
        
}
