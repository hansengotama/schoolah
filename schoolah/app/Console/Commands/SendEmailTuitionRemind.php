<?php

namespace App\Console\Commands;

use App\Mail\SendEmailTuition;
use App\Mail\SendEmailTuitionParent;
use App\Student;
use App\Tuition;
use App\TuitionHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailTuitionRemind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuition:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tuition Remind';

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
     * @return mixed
     */
    public function handle()
    {
        $tuitionHistories = TuitionHistory::where("status", "unpaid")->with(["tuition" => function($query){
            $query->whereDate("due_date", "<=", Carbon::now()->addDays(3))->whereDate("due_date", ">=", Carbon::now());
        }])->get();

//        $tuitionExpired = TuitionHistory::where("status", "unpaid")->with(["tuition" => function($query){
//            $query->whereDate("due_date", ">", Carbon::now());
//        }])->get();
        foreach ($tuitionHistories as $tuitionHistory) {
            if(isset($tuitionHistory->tuition)) {
                $student = Student::where("id", $tuitionHistory->student_id)->with(["user", "guardian" => function($query){
                    $query->with("user")->first();
                }])->first();

                $studentEmail = $student->user->email;
                $guardianEmail = $student->guardian->user->email;

                $data = [
                    "name" => $student->user->name,
                    "price" => number_format($tuitionHistory->tuition->price,"0",",","."),
                    "dueDate" => Carbon::parse($tuitionHistory->tuition->due_date)->format("d M Y"),
                    "description" => $tuitionHistory->tuition->description,
                    "guardian_name" => $student->guardian->user->name,
                ];

                Mail::to($studentEmail)->send(new SendEmailTuition('Tuition', $data));
                Mail::to($guardianEmail)->send(new SendEmailTuitionParent('Tuition', $data));
            }
        }
    }
}
