@php
    use App\Libs\PlowBack;
    use App\Libs\Helper;
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Изменить вклад ' . $credit->title))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-primary text-white">
                    <div class="card-header">{{ __('Изменить кредит') }}</div>

                    <div class="card-body bg-white">

                        <form action="{{ route('credit.update', $credit->credit_id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="creditTitle" class="form-label required">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="creditTitle" name="title" value="{{ $credit->title ?? '' }}" placeholder="Мой новый кредит" aria-describedby="creditTitleHelp">
                                <div id="creditTitleHelp" class="form-text">{{ __('Лейбл Вашего кредита для простоты идентификации') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="currency_id" class="form-label required">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</label>
                                <select class="form-select" id="currency_id" name="currency_id" aria-describedby="currencyHelp">
                                    @forelse($currencies as $currency)
                                        <option {{ $credit->currency == $currency->abbr ? 'selected': '' }} value="{{ $currency->currency_id }}">{{ $currency->abbr }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="currencyHelp" class="form-text">{{ __('В какой валюте кредит') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="creditCreditor" class="form-label required">{!! Icons::get(Icons::BANK) !!} {{ __('Кредитор') }}</label>
                                <input type="text" class="form-control" id="creditCreditor" name="creditor" value="{{ $credit->creditor ?? '' }}" placeholder="Новый банк" aria-describedby="creditCreditorHelp">
                                <div id="creditCreditorHelp" class="form-text">{{ __('Кто выдает кредит / займ') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="creditStart" class="form-label required">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('День взятия кредита') }}</label>
                                <input type="date" class="form-control" id="creditStart" name="start_date" value="{{ date('Y-m-d', $credit->start_date) }}" />
                            </div>

                            <div class="mb-3">
                                <label for="creditPayDay" class="form-label required">{!! Icons::get(Icons::CALENDAR) !!} {{ __('День первого платежа') }}</label>
                                <input type="date" class="form-control" id="creditPayDay" name="payment_date" value="{{ date('Y-m-d', $credit->payment_date) }}" />
                            </div>

                            <div class="mb-3">
                                <label for="creditAmount" class="form-label required">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="creditAmount" name="amount" value="{{ $credit->amount ?? '' }}" placeholder="250000">
                                    <span class="input-group-text bg-light currency">{{ $credit->currency->abbr }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="creditPercent" class="form-label required">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="creditPercent" name="percent" value="{{ $credit->percent ?? '' }}" placeholder="14.9">
                                    <span class="input-group-text bg-light">%</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="creditPeriod" class="form-label required">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="creditPeriod" name="period" value="{{ $credit->period ?? '' }}" placeholder="36">
                                    <span class="input-group-text bg-light">{{ __('месяцев') }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="creditPayment" class="form-label required">{!! Icons::get(Icons::BALANCE_START) !!} {{ __('Платеж') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="creditPayment" name="payment" value="{{ $credit->payment ?? '' }}" placeholder="8654.09" aria-describedby="creditPaymentHelp">
                                    <span class="input-group-text bg-light currency">{{ $credit->currency->abbr }}</span>
                                </div>
                                <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('credit.index') }}" class="btn btn-secondary me-md-2">{!! Icons::get(Icons::RETURN) !!}&nbsp;{{ __('Назад') }}</a>
                                    <button type="submit" class="btn btn-primary">{!! Icons::get(Icons::SAVE) !!}&nbsp;{{ __('Сохранить') }}</button>
                                </div>
                            </div>

                        </form>

                        @if(count($errors) > 0)
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">
            $(document).ready(function() {
                $('#currency').change(function() {
                    $('.currency').html($(this).val());
                });
            });
        </script>
    @endpush
@endsection
