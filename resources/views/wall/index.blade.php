@php
    use App\Libs\Icons;
    use App\Libs\Helper;
    use App\Enums\CurrencyEnum;
@endphp

@extends('layouts.app')

@section('title', __('Календарь событий'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-primary text-white">

                    <div class="card-header">{{ __('Календарь событий') }}</div>

                    <div class="card-body bg-white">

                        @desktop
                            <table class="table table-bordered mt-3 admin-table__adapt admin-table__instrument caption-top">
                                <caption>{{ __('Платежи в этом месяце') }}</caption>
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-start">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дата') }}</th>
                                        <th class="text-start">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                        <th class="text-start">{!! Icons::get(Icons::BANK) !!} {{ __('Банк') }}</th>
                                        <th class="text-end">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Платеж') }}</th>
                                        <th class="text-end">{!! Icons::get(Icons::CHECK) !!} {{ __('Статус') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($credits as $credit)
                                        <tr>
                                            <td data-label="{{ __('Дата') }}" class="text-start">{{ $credit['date'] }}</td>
                                            <td data-label="{{ __('Название') }}" class="text-start"><a href="{{ route('credit.show', $credit['credit_id']) }}">{{ $credit['title'] }}</a></td>
                                            <td data-label="{{ __('Банк') }}" class="text-start">{{ $credit['creditor'] }}</td>
                                            <td data-label="{{ __('Платеж') }}" class="text-end">{{ number_format($credit['payment'], 0, '.', ' ') }} {{ $credit['currency']['abbr'] }}</td>
                                            <td data-label="{{ __('Статус') }}" class="text-end {{ Helper::getPaymentTextColor($credit['date_time'], $credit['status']) }}"><i class="{{ Helper::getPaymentIcon($credit['date_time'], $credit['status']) }}"></i></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center p-2 mb-2 mt-2 bg-light bg-gradient text-success rounded">У Вас не текущих кредитов</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @elsedesktop
                            <table class="table table-borderless">
                                <tr class="table-secondary border-bottom border-top">
                                    <td colspan="2" class="text-center bg-light">Платежи в этом месяце</td>
                                </tr>

                                @forelse($credits as $credit)
                                    <tr>
                                        <td class="text-start"><i class="{{ Helper::getPaymentTextColor($credit['date_time'], $credit['status']) }} {{ Helper::getPaymentIcon($credit['date_time'], $credit['status']) }}"></i> {{ $credit['date'] }}</td>
                                        <td class="text-end">{!! Icons::get(Icons::BANK) !!} {{ $credit['creditor'] }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-start">{!! Icons::get(Icons::TITLE) !!} <a class="text-primary" href="{{ route('credit.show', $credit['credit_id']) }}">{{ $credit['title'] }}</a></td>
                                        <td class="text-end">{!! Icons::get(Icons::PAYMENT) !!} {{ number_format($credit['payment'], 0, '.', ' ') }} {{ $credit['currency']['abbr'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <div class="text-center p-2 mb-2 mt-2 bg-light bg-gradient text-success rounded">У Вас нет текущих кредитов</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        @enddesktop

                        @desktop
                            <table class="table table-bordered mt-3 admin-table__adapt admin-table__instrument caption-top">
                                <caption>{{ __('Сальдо за месяц') }}</caption>
                                <tr>
                                    <td class="text-secondary text-start" colspan="2">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} Финансовая нагрузка:</td>
                                    <td data-label="В RUB" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::RUB->name;}))), 0, '.', ' ') }} RUB</td>
                                    <td data-label="В USD" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::USD->name;}))), 0, '.', ' ') }} USD</td>
                                    <td data-label="В EUR" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::EUR->name;}))), 0, '.', ' ') }} EUR</td>
                                </tr>
                                <tr>
                                    <td class="text-success text-start" colspan="2">{!! Icons::get(Icons::SMILE_HAPPY) !!} Выплачено в этом месяце:</td>
                                    <td data-label="В RUB" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::RUB->name && $e['status'] == true;}))), 0, '.', ' ') }} RUB</td>
                                    <td data-label="В USD" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::USD->name && $e['status'] == true;}))), 0, '.', ' ') }} USD</td>
                                    <td data-label="В EUR" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::EUR->name && $e['status'] == true;}))), 0, '.', ' ') }} EUR</td>
                                </tr>
                                <tr>
                                    <td class="text-danger text-start" colspan="2">{!! Icons::get(Icons::SMILE_SAD) !!} Осталось выплатить в этом месяце:</td>
                                    <td data-label="В RUB" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::RUB->name && $e['status'] == false;}))), 0, '.', ' ') }} RUB</td>
                                    <td data-label="В USD" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::USD->name && $e['status'] == false;}))), 0, '.', ' ') }} USD</td>
                                    <td data-label="В EUR" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::EUR->name && $e['status'] == false;}))), 0, '.', ' ') }} EUR</td>
                                </tr>
                            </table>
                        @elsedesktop
                            <table class="table table-borderless mt-3">
                                <tr class="table-secondary border-bottom border-top">
                                    <td colspan="3" class="text-center bg-light">Месячное сальдо</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-start">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} Финансовая нагрузка</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td data-label="В RUB" class="text-start">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::RUB->name;}))), 0, '.', ' ') }} RUB</td>
                                    <td data-label="В USD" class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::USD->name;}))), 0, '.', ' ') }} USD</td>
                                    <td data-label="В EUR" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::EUR->name;}))), 0, '.', ' ') }} EUR</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-start">{!! Icons::get(Icons::SMILE_HAPPY) !!} Выплачено в этом месяце</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td data-label="В RUB" class="text-start">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::RUB->name && $e['status'] == true;}))), 0, '.', ' ') }} RUB</td>
                                    <td data-label="В USD" class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::USD->name && $e['status'] == true;}))), 0, '.', ' ') }} USD</td>
                                    <td data-label="В EUR" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::EUR->name && $e['status'] == true;}))), 0, '.', ' ') }} EUR</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-start">{!! Icons::get(Icons::SMILE_SAD) !!} Осталось выплатить</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td data-label="В RUB" class="text-start">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::RUB->name && $e['status'] == false;}))), 0, '.', ' ') }} RUB</td>
                                    <td data-label="В USD" class="text-center">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::USD->name && $e['status'] == false;}))), 0, '.', ' ') }} USD</td>
                                    <td data-label="В EUR" class="text-end">{{ number_format(array_sum(array_map(function($e){return $e['payment'];}, array_filter($credits, function($e) {return $e['currency']['abbr'] == CurrencyEnum::EUR->name && $e['status'] == false;}))), 0, '.', ' ') }} EUR</td>
                                </tr>
                            </table>
                        @enddesktop

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
