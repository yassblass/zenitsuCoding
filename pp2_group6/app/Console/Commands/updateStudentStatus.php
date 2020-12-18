<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Carbon\Carbon;

class updateStudentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-student-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the hasRight status of students back to true after 15min.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Fetch all students.
        $studentFields = Student::all();

        //When a student inputs wrong verificaiton code 3 times in a row, 'hasRight' changes to 0. No appointment request can be made.
        //For each student, update 'hasRight' to 1 if 15 minutes passed.
        foreach($studentFields as $student) {
            
            //When pass 3 times wrong, hasRight changes to 0, which also sets the 'updated_at' field to the date of the moment itself.
            //We can use this field to make the 'hasRight' field back to 1.

            //isolate updated_at.
            $updatedAt = $student['updated_at'];

            //Isolate 'updated_at' value + 15 minutes.
            $interval = $updatedAt->addMinutes(15);

            //Query needs to match this where clausule.
            $matchThese = ['student_id' => $student['student_id'], 'hasRight' => 0];

            //IF 'updated_at' + 15 minutes >= now => set hasRight back to 1.
            if($interval <=  Carbon::now()){
                Student::where($matchThese)->update(['hasRight' => 1]);
            };
        }
    }
}
