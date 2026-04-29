<!DOCTYPE html>
<html>
<head>
    <title>Vulnerability Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; font-size: 14px; }
        th { background-color: #f2f2f2; }
        .critical { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Security Vulnerability Report</h2>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vulnerability Name</th>
                <th>Severity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($findings as $finding)
            <tr>
                <td>{{ $finding->id }}</td>
                <td>{{ $finding->title }}</td>
                <td class="{{ $finding->severity == 'Critical' ? 'critical' : '' }}">{{ $finding->severity }}</td>
                <td>{{ $finding->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
