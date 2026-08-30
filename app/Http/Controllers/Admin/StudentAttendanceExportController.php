<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentAttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentAttendanceReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentAttendanceExportController extends Controller
{
    public function __invoke(
        Request $request,
        Student $student,
        string $format,
        StudentAttendanceReportService $reportService,
    ): Response|BinaryFileResponse {
        abort_unless(in_array($format, ['pdf', 'excel'], true), 404);

        $validated = $request->validate([
            'academic_year_id' => ['nullable', 'integer', 'exists:academic_years,id'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $report = $reportService->build(
            $student,
            isset($validated['academic_year_id']) ? (int) $validated['academic_year_id'] : null,
            $validated['date_from'] ?? null,
            $validated['date_to'] ?? null,
        );

        $filename = 'attendance-'.str($student->lastname.'-'.$student->firstname)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', '-')
            ->trim('-');

        if ($format === 'excel') {
            return Excel::download(new StudentAttendanceExport($report), $filename.'.xlsx');
        }

        return Pdf::loadView('exports.student-attendance-pdf', ['report' => $report])
            ->setPaper('a4')
            ->download($filename.'.pdf');
    }
}
