<div class="table-responsive">
    <h1>{{ $symbol }}</h1><span class="xs">{{ $company->name ?? '' }}</span>

    <table class="table table-striped table-sm align-middle" style="font-size:14px">
        <thead>
            <tr>
                <th>Date</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>AdjClose</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ticker as $t)
                <tr>
                    <td>{{ $t['date'] ?? '-' }}</td>
                    <td>{{ $t['o'] ?? '-' }}</td>
                    <td>{{ $t['h'] ?? '-' }}</td>
                    <td>{{ $t['l'] ?? '-' }}</td>
                    <td>{{ $t['c'] ?? '-' }}</td>
                    <td>{{ $t['adjclose'] ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
