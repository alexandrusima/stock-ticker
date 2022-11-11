<nav class="navbar navbar-expand-lg bg-light shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Stock Ticker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{ Form::open([
            'route' => ['post'],
            'method' => 'post',
            'class' => ['d-flex'],
        ]) }}
        <input class="form-control me-2" value="{{ old('symbol', $request->get('symbol', 'ADES')) }}" name="symbol"
            type="search" placeholder="Company Symbol" aria-label="Company Symbol">
        <input class="form-control me-2" value="{{ old('start_date', $validated['start_date'] ?? '') }}"
            name="start_date" type="date" placeholder="Start date" aria-label="Start date">
        <input class="form-control me-2" value="{{ old('end_date', $validated['end_date'] ?? '') }}" name="end_date"
            type="date" placeholder="End date" aria-label="End date">
        <input class="form-control me-2" value="{{ old('email', $validated['email'] ?? '') }}" name="email"
            type="email" placeholder="Email" aria-label="Email">
        <button class="btn btn-outline-success" type="submit">GO!</button>
        {{ Form::token() }}
        {{ Form::close() }}
    </div>
</nav>
