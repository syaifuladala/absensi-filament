<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class DownloadController extends Controller
{
    public function getDownload($model)
    {
        try {
            $title = $model;
            switch ($model) {
                case 'user':
                    $data = User::select('name', 'email', 'phone', 'position')
                        ->get()->toArray();
                    $header = ['Name', 'Email', 'Phone', 'position'];
                    $width = ['30%', '25%', '20%', '20%'];
                    $title = 'User List';
                    break;
                case 'attendance':
                    $report = DB::table('attendances')->select(
                            'users.name',  
                            DB::raw("DATE_FORMAT(attendances.date, '%e %M %Y') AS date"),
                            DB::raw("DATE_FORMAT(attendances.clock_in, '%H:%i') AS clock_in"),
                            DB::raw("DATE_FORMAT(attendances.clock_out, '%H:%i') AS clock_out"),
                            DB::raw("CASE WHEN attendances.late = 1 THEN 'Yes' ELSE 'No' END AS late")
                        )
                        ->join('users', 'attendances.user_id', '=','users.id')
                        ->orderBy('attendances.updated_at', 'DESC')
                        ->get();
                    $data = $report->map(function ($record) {
                        return [
                            'name' => $record->name,
                            'date' => $record->date,
                            'clock_in' => $record->clock_in,
                            'clock_out' => $record->clock_out,
                            'late' => $record->late,
                        ];
                    })->toArray();
                    $header = ['Name', 'Date', 'Clock In', 'Clock Out', 'Late'];
                    $width = ['25%', '20%', '20%', '20%', '10%'];
                    $title = 'Attendance List';
                    break;
            }

            $convert = [
                'title' => $title,
                'header' => $header,
                'data' => $data,
                'width' => $width,
            ];

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
            $pdf->getDomPDF()->set_option("isPhpEnabled", true);
            $pdf->loadView('download', $convert)->render();

            return $pdf->download($title . ' ' . Carbon::now()->format('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
