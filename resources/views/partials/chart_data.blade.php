<script type="text/javascript">
    window.chart_data = {
        title: "{{ $symbol }} - {{ $company->name ?? 'not-set' }}",
        data: @json($ticker, JSON_PRETTY_PRINT)
    };
</script>
