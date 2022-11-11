<script type="text/javascript">
    window.chart_data = {
        title: "{{ $company->symbol }} - {{ $company->name }}",
        data: @json($ticker, JSON_PRETTY_PRINT)
    };
</script>
