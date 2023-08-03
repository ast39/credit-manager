@php
    use App\Enums\CreditSubjectEnum;
    use App\Libs\Icons;
    use App\Libs\Helper;
    use Illuminate\Support\Facades\Lang;
@endphp

@section('title', __('Расчет кредита ' . $info->credit->title))

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-primary text-white">

                    <div class="card-header">{{ __('Информация по расчету кредита') }}</div>

                    <div class="card-body bg-white">

                        <table class="table table-borderless">
                            <tbody>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <td class="text-end">{{ $info->credit->title ?? '' }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::BALANCE) !!} {{ __('Сумма') }}</th>
                                    <td class="text-end"><span class="{{ $info->credit->subject == CreditSubjectEnum::Amount->value ? 'text-primary' : '' }}">{{ number_format($info->credit->amount ?? 0, 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</span></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</th>
                                    <td class="text-end"><span class="{{ $info->credit->subject == CreditSubjectEnum::Percent->value ? 'text-primary' : '' }}">{{ number_format($info->credit->percent ?? 0, 2, '.', ' ') }}%</span></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</th>
                                    <td class="text-end"><span class="{{ $info->credit->subject == CreditSubjectEnum::Period->value ? 'text-primary' : '' }}">{{ $info->credit->period ?? 0 }} {{ Lang::choice('месяц|месяца|месяцев', $info->credit->period ?? 0) }}</span></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::BALANCE_CASH) !!} {{ __('Платеж') }}</th>
                                    <td class="text-end"><span class="{{ $info->credit->subject == CreditSubjectEnum::Payment->value ? 'text-primary' : '' }}">{{ number_format($info->credit->payment ?? 0, 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</span></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::SMILE_HAPPY) !!} {{ __('Тело кредита') }}</th>
                                    <td class="text-end"><span class="text-success">{{ number_format($info->payments ?? 0, 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</span></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::SMILE_SAD) !!} {{ __('Проценты по кредиту') }}</th>
                                    <td class="text-end"><span class="text-danger">{{ number_format($info->overpay ?? 0, 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</span></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="text-start">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} {{ __('Итого выплат') }}</th>
                                    <td class="text-end"><span class="text-primary">{{ number_format($info->total_amount ?? 0, 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="accordion">
                            <div class="accordion-item mt-3">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        {{ __('График платежей') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body bg-white">

                                        @desktop
                                            <table class="table table-bordered admin-table__adapt admin-table__instrument">
                                                <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center" scope="row">{!! Icons::get(Icons::LIST) !!}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::INSET_LR) !!} {{ __('Входящий баланс') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::SMILE_NEUTRAL) !!} {{ __('Сумма платежа') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::SMILE_SAD) !!} {{ __('Проценты') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::SMILE_HAPPY) !!} {{ __('Тело') }}</th>
                                                    <th class="text-end">{!! Icons::get(Icons::OUTSET_LR) !!} {{ __('Исходящий баланс') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($info->details as $row)
                                                    <tr>
                                                        <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                        <td data-label="Баланс" class="text-end">{{ number_format($row['inset_balance'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                        <td data-label="Платеж" class="text-end">{{ number_format($row['credit_payment'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                        <td data-label="Проценты" class="text-end">{{ number_format($row['payment_percent'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                        <td data-label="Тело" class="text-end">{{ number_format($row['payment_body'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                        <td data-label="Остаток" class="text-end">{{ number_format($row['outset_balance'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                    </tr>
                                                @empty
                                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Расчет не удался') }}</div>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        @elsedesktop
                                            <table class="table table-borderless">
                                                <tbody>
                                                    @forelse($info->details as $row)
                                                        <tr>
                                                            <td class="text-start">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ date('d.m.Y', $row['date_time']) }}</td>
                                                            <td class="text-end">{!! Icons::get(Icons::PAYMENT) !!} {{ number_format($row['credit_payment'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-start">{!! Icons::get(Icons::PERCENT) !!} {{ number_format($row['payment_percent'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                            <td class="text-end">{!! Icons::get(Icons::OUTSET_LR) !!} {{ number_format($row['outset_balance'], 0, '.', ' ') }} {{ $info->credit->currency->abbr }}</td>
                                                        </tr>
                                                        <tr class="mb-3">
                                                            <td colspan="2">
                                                                <div class="progress" style="height: 2px;">
                                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ 100 - ($row['outset_balance'] / $info->credit->amount * 100) }}%;" aria-valuenow="{{ 100 - ($row['outset_balance'] / $info->credit->amount * 100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Расчет не удался') }}</div>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        @enddesktop

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex mt-3 justify-content-md-center">
                            @auth()
                                <a href="{{ route('credit.calc.index') }}" class="btn btn-secondary me-1 rounded">{!! Icons::get(Icons::RETURN) !!}&nbsp;{{ __('Назад') }}</a>
                            @endauth
                            <a href="{{ route('credit.calc.create') }}" class="btn btn-primary rounded">{!! Icons::get(Icons::CALCULATE) !!}&nbsp;{{ __('Рассчитать новый кредит') }}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
