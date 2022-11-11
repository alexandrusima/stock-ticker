<x-mail::message>
    # {{ $symbol }}
    -------------
    {{ $company->name ?? '' }}

    | DATE | OPEN | HIGH | LOW | CLOSE | ADJCLOSE | VOLUME |
    |------|------|------|-----|-------|----------|--------|
    @foreach ($ticker as $t)
        | {{ $t['date'] ?? '-' }} | {{ $t['o'] ?? '-' }} | {{ $t['h'] ?? '-' }} | {{ $t['l'] ?? '-' }} |
        {{ $t['c'] ?? '-' }} | {{ $t['adjclose'] ?? '-' }} | {{ $t['volume'] ?? '-' }} |
    @endforeach


    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
