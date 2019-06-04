<?php

namespace App\Http\Controllers\Api\Secured;

use Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\EmployeeReport;
use App\Mail\DailyReport;


class SendReportController extends Controller
{
    public function send(Request $request)
    {
        try {
            $employeeReports = EmployeeReport::where('sent', 0)->get();

            foreach($employeeReports as $employeeReport) {
                Mail::to($employeeReport->send_to)
                ->queue(new DailyReport($employeeReport));
            }

            // $contact = null;
            // $employee = Employee::where('user_id', (int)$request->employeeId )->first();
            // if (isset($request->clientContact['id'])) 
            //     $contact = ClientContact::find( (int)$request->clientContact['id'] );
            
            // if (!$contact) {
            //     $contact = new ClientContact();
            //     $contact->email = $request->email;
            //     $contact->name = "Matt Decoursey";
            // }
            
            // Notification::send($contact, new MailDailyReport($employee, $contact, $request));
            // $result = $this->save_employee_report($request, 1);
            $response =  response()->json([
                'status' => 200,
                'message' => "Success"
            ], 200);   

        } catch (Exception $e) {
            // $result = $this->save_employee_report($request, 0);

            $response = response()->json([
                'status' => 500,
                'message' => 'Error sending report'
            ], 500);   
        }

        return $response;
    }
}
