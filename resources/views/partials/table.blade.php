<div class="table-responsive">
    {{ $companies->links() }}
    <table class="table table-striped table-sm align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Symbol</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <th scope="row">{{ $company->id }}</th>
                    <td>{{ $company->symbol }}</td>
                    <td>{{ $company->name }}
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $companies->links() }}
</div>
