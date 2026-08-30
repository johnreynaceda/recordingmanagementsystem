<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Attendance Report</title>
    <style>
        @page { margin: 32px; }
        body { color: #1f2937; font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { color: #991b1b; font-size: 20px; margin: 0 0 5px; }
        .meta { line-height: 1.7; margin: 18px 0; }
        .summary { border-collapse: separate; border-spacing: 8px 0; margin: 0 -8px 18px; width: calc(100% + 16px); }
        .summary td { background: #f9fafb; border: 1px solid #e5e7eb; padding: 10px; }
        .summary strong { display: block; font-size: 17px; margin-top: 3px; }
        .records { border-collapse: collapse; width: 100%; }
        .records th { background: #991b1b; color: white; font-size: 10px; padding: 8px; text-align: left; text-transform: uppercase; }
        .records td { border-bottom: 1px solid #e5e7eb; padding: 8px; }
        .present { color: #047857; font-weight: bold; }
        .empty { color: #6b7280; padding: 24px; text-align: center; }
        .footer { color: #9ca3af; font-size: 9px; margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <h1>Student Attendance Report</h1>
    <div class="meta">
        <strong>Student:</strong> {{ $report['student']->lastname }}, {{ $report['student']->firstname }} {{ $report['student']->middlename }}<br>
        <strong>LRN:</strong> {{ $report['student']->lrn ?? 'N/A' }}<br>
        <strong>Academic Year:</strong> {{ $report['academic_year']?->name ?? 'N/A' }}<br>
        <strong>Date Range:</strong> {{ \Carbon\Carbon::parse($report['date_from'])->format('M d, Y') }} – {{ \Carbon\Carbon::parse($report['date_to'])->format('M d, Y') }}
    </div>

    <table class="summary">
        <tr>
            <td>School Days<strong>{{ $report['summary']['school_days'] }}</strong></td>
            <td>Present<strong>{{ $report['summary']['present'] }}</strong></td>
            <td>Absent<strong>{{ $report['summary']['absent'] }}</strong></td>
            <td>Rate<strong>{{ $report['summary']['rate'] }}%</strong></td>
        </tr>
    </table>

    <table class="records">
        <thead>
            <tr><th>Date</th><th>Day</th><th>Grade Level</th><th>Section</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse ($report['details'] as $detail)
                <tr>
                    <td>{{ $detail['formatted_date'] }}</td>
                    <td>{{ $detail['day'] }}</td>
                    <td>{{ $detail['grade_level'] }}</td>
                    <td>{{ $detail['section'] }}</td>
                    <td class="present">{{ $detail['status'] }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No attendance records found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Generated {{ now()->format('M d, Y g:i A') }}</div>
</body>
</html>
