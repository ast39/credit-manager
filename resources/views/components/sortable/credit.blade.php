@php
    Use App\Libs\Icons;
@endphp

{{--@desktop--}}
{{--    <div class="card-title">--}}
{{--        <ul class="nav nav-tabs">--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-decoration-none text-primary {{ $sortable == 'till' ? 'active' : '' }}" href="{{ route('credit.index', 'till') . '?'. request()->getQueryString() }}" >{{ __('Дней до платежа') }}</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-decoration-none text-primary {{ $sortable == 'percent' ? 'active' : '' }}" href="{{ route('credit.index', 'percent') . '?' . request()->getQueryString() }}">{{ __('По проценту') }}</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-decoration-none text-primary {{ $sortable == 'amount' ? 'active' : '' }}" href="{{ route('credit.index', 'amount') . '?' . request()->getQueryString() }}">{{ __('По сумме') }}</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-decoration-none text-primary {{ $sortable == 'payment' ? 'active' : '' }}" href="{{ route('credit.index', 'payment') . '?' . request()->getQueryString() }}">{{ __('По платежу') }}</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-decoration-none text-primary {{ $sortable == 'overpay' ? 'active' : '' }}" href="{{ route('credit.index', 'overpay') . '?' . request()->getQueryString() }}" >{{ __('По переплате') }}</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@elsedesktop--}}
    <div class="mb-3">
        <label for="currency_id" class="form-label">{!! Icons::get(Icons::SORTABLE) !!} {{ __('Сортировка') }}</label>
        <select class="form-control form-select" id="currency_id" name="currency_id" aria-describedby="currencyHelp">
            <option {{ $sortable == 'till' ? 'selected' : '' }} value="{{ route('credit.index', 'till') . '?'. request()->getQueryString() }}">{{ __('Дней до платежа') }}</option>
            <option {{ $sortable == 'percent' ? 'selected' : '' }} value="{{ route('credit.index', 'percent') . '?'. request()->getQueryString() }}">{{ __('По проценту') }}</option>
            <option {{ $sortable == 'amount' ? 'selected' : '' }} value="{{ route('credit.index', 'amount') . '?'. request()->getQueryString() }}">{{ __('По сумме') }}</option>
            <option {{ $sortable == 'payment' ? 'selected' : '' }} value="{{ route('credit.index', 'payment') . '?'. request()->getQueryString() }}">{{ __('По платежу') }}</option>
            <option {{ $sortable == 'overpay' ? 'selected' : '' }} value="{{ route('credit.index', 'overpay') . '?'. request()->getQueryString() }}">{{ __('По переплате') }}</option>
        </select>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                 $('#currency_id').change(function() {
                     window.location.replace($(this).val());
                 });
            });
        </script>
    @endpush
{{--@enddesktop--}}
