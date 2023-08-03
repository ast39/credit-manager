@php
    use App\Libs\Icons;
    use App\Libs\Helper;
    use Illuminate\Support\Facades\Lang;
@endphp

@extends('layouts.app')

@section('title', __('Проверка кредита ' . $checker->credit->title))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-primary text-white">
                    <div class="card-header">{{ __('Итоги проверки кредита') }} (<span class="small text-white">{{ $checker->credit->title }}</span>)</div>
                    <div class="card-body bg-white">

                        <div class="accordion" id="accordionPanelsStayOpenExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button bg-light text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        {{ __('Параметры кредита') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body bg-white">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <th scope="row">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</th>
                                                    <td class="text-end">{{ number_format($checker->credit->amount, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th scope="row">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</th>
                                                    <td class="text-end">{{ number_format($checker->credit->percent, 2, '.', ' ') }}%</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th scope="row">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</th>
                                                    <td class="text-end">{{ Helper::creditPeriod($checker->credit->period ?? 0) }}</td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th scope="row">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Платеж') }}</th>
                                                    <td class="text-end">{{ number_format($checker->credit->payment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        {!! Icons::get(Icons::CHECK) !!}&nbsp;{{ __('Проверка суммы кредита') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body bg-white">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Проверочная сумма кредита') }}</th>
                                                <td class="text-end">{{ number_format($checker->credit->amount, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Реальная сумма кредита') }}</th>
                                                <td class="text-end">{{ number_format($checker->real_amount, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Скрытая удерживаемая сумма') }}</th>
                                                <td class="text-end">
                                                    <span class="{{ $checker->hidden_amount > 0 ? 'text-danger': 'text-success' }}">{{ number_format($checker->hidden_amount, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        {!! Icons::get(Icons::CHECK) !!}&nbsp;{{ __('Проверка процента кредита') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="accordion-body bg-white">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Проверочный процент кредита') }}</th>
                                                <td class="text-end">{{ number_format($checker->credit->percent, 2, '.', ' ') }}%</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Реальный процент кредита') }}</th>
                                                <td class="text-end">{{ number_format($checker->real_percent, 2, '.', ' ') }}%</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Скрытое завышение процента') }}</th>
                                                <td class="text-end">
                                                    <span class="{{ $checker->hidden_percent > 0 ? 'text-danger': 'text-success' }}">{{ number_format($checker->hidden_percent, 2, '.', ' ') }}%</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingFour">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                                        {!! Icons::get(Icons::CHECK) !!}&nbsp;{{ __('Проверка срока кредита') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                                    <div class="accordion-body bg-white">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Проверочный срок кредита') }}</th>
                                                <td class="text-end">{{ $checker->credit->period }} {{ Lang::choice('месяц|месяца|месяцев', $checker->credit->period) }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Реальный срок кредита') }}</th>
                                                <td class="text-end">{{ $checker->real_period }} {{ Lang::choice('месяц|месяца|месяцев', $checker->real_period) }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Завышение срока кредита') }}</th>
                                                <td class="text-end">
                                                    <span class="{{ $checker->hidden_period > 0 ? 'text-danger': 'text-success' }}">{{ $checker->hidden_period }} {{ Lang::choice('месяц|месяца|месяцев', $checker->hidden_period) }}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingFifth">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFifth" aria-expanded="false" aria-controls="panelsStayOpen-collapseFifth">
                                        {!! Icons::get(Icons::CHECK) !!}&nbsp;{{ __('Проверка платежа по кредиту') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFifth" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFifth">
                                    <div class="accordion-body bg-white">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Проверочный платеж по кредиту') }}</th>
                                                <td class="text-end">{{ number_format($checker->credit->payment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Реальный платеж по кредиту') }}</th>
                                                <td class="text-end">{{ number_format($checker->real_payment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Завышение ежемесячного платежа') }}</th>
                                                <td class="text-end">
                                                    <span class="{{ $checker->hidden_payment > 0 ? 'text-danger': 'text-success' }}">{{ number_format($checker->hidden_payment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingSix">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
                                        {!! Icons::get(Icons::CHECK) !!}&nbsp;{{ __('Итоги проверки') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
                                    <div class="accordion-body bg-white">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Вы занимаете') }}</th>
                                                <td class="text-end">{{ number_format($checker->credit->amount, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Вы отдадите') }}</th>
                                                <td class="text-end">{{ number_format($checker->credit->amount + $checker->total_overpayment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Процентов за весь срок') }}</th>
                                                <td class="text-end">{{ number_format($checker->total_percent, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Скрытые страховки') }}</th>
                                                <td class="text-end">
                                                    <span class="{{ $checker->hidden_overpayment > 0 ? 'text-danger': 'text-success' }}">{{ number_format($checker->hidden_overpayment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</span>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <th scope="row">{{ __('Итоговая переплата') }}</th>
                                                <td class="text-end">{{ number_format($checker->total_overpayment, 0, '.', ' ') }} {{ $checker->credit->currency->abbr }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex mt-3 justify-content-md-center">
                            @auth()
                                <a href="{{ route('credit.check.index') }}" class="btn btn-secondary me-1 rounded">{!! Icons::get(Icons::RETURN) !!}&nbsp;{{ __('Назад') }}</a>
                            @endauth
                            <a href="{{ route('credit.check.create') }}" class="btn btn-primary rounded">{!! Icons::get(Icons::CHECK) !!}&nbsp;{{ __('Новая проверка') }}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
