@php
    use App\Enums\CreditSubjectEnum;
    use App\Enums\PaymentTypeEnum;
    use App\Libs\Icons;
    use App\Enums\CurrencyEnum;
@endphp

@extends('layouts.app')

@section('title', __('Новый расчет кредита'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-primary text-white">
                    <div class="card-header">{{ __('Рассчитать кредит') }}</div>
                    <div class="card-body bg-white">

                        <div class="text-end">
                            <a class="text-primary" href="{{ route('credit.calc.index') }}">История расчетов</a>
                        </div>

                        <form method="post" action="{{ route('credit.calc.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="title" class="form-label required">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" readonly class="form-control" id="title" name="title" value="Расчет от {{ date('d.m.Y H:i:s') }}">
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label required">{!! Icons::get(Icons::QUESTION) !!} {{ __('Что нужно рассчитать') }}</label>
                                <select class="form-select" id="subject" name="subject" aria-describedby="subjectHelp">
                                    <option {{ (old('subject') ?? CreditSubjectEnum::Payment->value) == CreditSubjectEnum::Amount->value  ? 'selected': '' }} value="{{ CreditSubjectEnum::Amount->value }}">{{ __('Сумму кредита') }}</option>
                                    <option {{ (old('subject') ?? CreditSubjectEnum::Payment->value) == CreditSubjectEnum::Percent->value ? 'selected': '' }} value="{{ CreditSubjectEnum::Percent->value }}">{{ __('Процент по кредиту') }}</option>
                                    <option {{ (old('subject') ?? CreditSubjectEnum::Payment->value) == CreditSubjectEnum::Period->value  ? 'selected': '' }} value="{{ CreditSubjectEnum::Period->value }}">{{ __('Срок кредита') }}</option>
                                    <option {{ (old('subject') ?? CreditSubjectEnum::Payment->value) == CreditSubjectEnum::Payment->value ? 'selected': '' }} value="{{ CreditSubjectEnum::Payment->value }}">{{ __('Ежемесячный платеж') }}</option>
                                </select>
                                <div id="subjectHelp" class="form-text">{{ __('Выбранное поле заполнять не надо') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="currency_id" class="form-label required">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</label>
                                <select class="form-select" id="currency_id" name="currency_id" aria-describedby="currencyHelp">
                                    @forelse($currencies as $currency)
                                        <option {{ old('currency') == $currency->abbr ? 'selected': '' }} value="{{ $currency->currency_id }}">{{ $currency->abbr }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="currencyHelp" class="form-text">{{ __('В какой валюте кредит') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="payment_type" class="form-label required">{!! Icons::get(Icons::LIST) !!} {{ __('Тип платежа') }}</label>
                                <select class="form-select" id="payment_type" name="payment_type" aria-describedby="payment_typeHelp">
                                    <option {{ old('payment_type') == PaymentTypeEnum::Annuitant->value  ? 'selected': '' }} value="{{ PaymentTypeEnum::Annuitant->value }}">{{ __('Аннуитетный') }}</option>
                                    <option {{ old('payment_type') == PaymentTypeEnum::Difference->value ? 'selected': '' }} value="{{ PaymentTypeEnum::Difference->value }}">{{ __('Дифференцированный') }}</option>
                                </select>
                                <div id="payment_typeHelp" class="form-text">{{ __('Выберите тип платежа по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" {{ old('amount') == CreditSubjectEnum::Amount->value ? 'disabled' : '' }} class="form-control subjects" id="amount" name="amount" placeholder="250000" value="{{ old('amount') }}" aria-describedby="amountHelp">
                                    <span class="input-group-text currency bg-light">{{ CurrencyEnum::RUB->name }}</span>
                                </div>
                                <div id="amountHelp" class="form-text mb-3">{{ __('Сумма кредита') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="percent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" {{ old('percent') == CreditSubjectEnum::Percent->value  ? 'disabled' : '' }} class="form-control subjects" id="percent" name="percent" placeholder="14.9" value="{{ old('percent') }}" aria-describedby="percentHelp">
                                    <span class="input-group-text bg-light">%</span>
                                </div>
                                <div id="percentHelp" class="form-text mb-3">{{ __('Процент по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="period" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" {{ old('period') == CreditSubjectEnum::Period->value  ? 'disabled' : '' }} class="form-control subjects" id="period" name="period" placeholder="36" value="{{ old('period') }}" aria-describedby="periodHelp">
                                    <span class="input-group-text bg-light">месяцев</span>
                                </div>
                                <div id="periodHelp" class="form-text mb-3">{{ __('Срок кредита в месяцах') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="payment" class="form-label">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Платеж') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" {{ old('payment') == null ? 'disabled' : (old('payment') == CreditSubjectEnum::Payment->value  ? 'disabled' : '') }} class="form-control subjects" id="payment" name="payment" placeholder="8654.09" value="{{ old('payment') }}" aria-describedby="paymentHelp">
                                    <span class="input-group-text currency bg-light">{{ CurrencyEnum::RUB->name }}</span>
                                </div>
                                <div id="paymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <button type="submit" class="btn btn-primary rounded">{!! Icons::get(Icons::CALCULATE) !!}&nbsp;{{ __('Рассчитать') }}</button>
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
                $('#subject').change(function() {
                    let subject = $(this).val();

                    $('.subjects').attr('disabled', false);

                    if (subject === '{{ CreditSubjectEnum::Amount->value }}') {
                        $('#amount').attr('disabled', true).val('');
                    }
                    if (subject === '{{ CreditSubjectEnum::Percent->value }}') {
                        $('#percent').attr('disabled', true).val('');
                    }
                    if (subject === '{{ CreditSubjectEnum::Period->value }}') {
                        $('#period').attr('disabled', true).val('');
                    }
                    if (subject === '{{ CreditSubjectEnum::Payment->value }}') {
                        $('#payment').attr('disabled', true).val('');
                    }
                });

                $('#currency').change(function() {
                    $('.currency').html($(this).val());
                });
            });
        </script>
    @endpush
@endsection
