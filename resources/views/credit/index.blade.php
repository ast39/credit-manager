@php
    use App\Libs\Icons;
    use App\Libs\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Мои кредиты'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-primary text-white">

                    <div class="card-header">{{ __('Мои кредиты') }}</div>

                    <div class="card-body bg-white">

                        <!-- Фильтр -->
                        <div class="mmot-margin20">
                            @include('components/filters/credit')
                        </div>

                        <!-- Сортировка -->
                        <div class="mmot-margin20">
                            @include('components/sortable/credit')
                        </div>

                        @desktop
                            <table class="table table-bordered admin-table__adapt admin-table__instrument">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-start">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                        <th class="text-center">{!! Icons::get(Icons::BANK) !!} {{ __('Банк') }}</th>
                                        <th class="text-center">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дней до платежа') }}</th>
                                        <th class="text-end">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Сумма платежа') }}</th>
                                        <th class="text-end">{!! Icons::get(Icons::SMILE_HAPPY) !!} {{ __('Выплачено долга') }}</th>
                                        <th class="text-end">{!! Icons::get(Icons::SMILE_SAD) !!} {{ __('Остаток долга') }}</th>
                                        <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($credits as $credit)
                                        <tr>
                                            <td data-label="{{ __('Название') }}"><a class="text-decoration-none text-primary" href="{{ route('credit.show', $credit->credit->credit_id) }}">{{ $credit->credit->title ?? '' }}</a></td>
                                            <td data-label="{{ __('Банк') }}" class="text-center">{{ $credit->credit->creditor ?? '' }}</td>

                                            <td data-label="{{ __('Дней до платежа') }}" class="text-center {{ $credit->days_to <= 5 ? 'text-danger' : ($credit->days_to <= 10 ? 'text-warning' : 'text-success') }}">
                                                {{ Helper::paymentStatus($credit->days_to) }}
                                            </td>
                                            <td data-label="{{ __('Сумма платежа') }}" class="text-end">{{ number_format($credit->credit->payment, 0, '.', ' ')}} {{ $credit->credit->currency->abbr }}</td>
                                            <td data-label="{{ __('Выплачено долга') }}" class="text-end">{{ number_format($credit->balance_payed, 0, '.', ' ') }} {{ $credit->credit->currency->abbr }}</td>
                                            <td data-label="{{ __('Остаток') }}" class="text-end">{{ number_format($credit->balance_owed, 0, '.', ' ') }} {{ $credit->credit->currency->abbr }}</td>
                                            <td data-label="{{ __('Действия') }}" class="text-end">
                                                <form method="post" action="{{ route('credit.destroy', $credit->credit->credit_id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="mmot-table__action">
                                                        <a title="Перейти" href="{{ route('credit.show', $credit->credit->credit_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-view"></use></svg></a>
                                                        <a title="Редактировать" href="{{ route('credit.edit', $credit->credit->credit_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-edit"></use></svg></a>
                                                        <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('Вы уверены, что хотите удалить кредит?')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center p-2 mb-2 mt-2 bg-light bg-gradient text-success rounded">{{ __('У вас нет текущих кредитов') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @elsedesktop
                            <table class="table table-borderless">
                                <tr class="table-secondary border-bottom border-top">
                                    <td colspan="2" class="text-center bg-light">Найденные кредиты</td>
                                </tr>
                                @forelse($credits as $credit)
                                    <tr>
                                        <td class="text-start">{!! Icons::get(Icons::TITLE) !!} <a class="text-decoration-none text-primary" href="{{ route('credit.show', $credit->credit->credit_id) }}">{{ $credit->credit->title ?? '' }}</a></td>
                                        <td class="text-end">{!! Icons::get(Icons::OUTSET_LR) !!} {{ number_format($credit->balance_owed, 0, '.', ' ') }} {{ $credit->credit->currency->abbr }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">{!! Icons::get(Icons::INSET_LR) !!} {{ number_format($credit->balance_payed, 0, '.', ' ')}} {{ $credit->credit->currency->abbr }}</td>
                                        <td class="text-end {{ $credit->days_to <= 5 ? 'text-danger' : ($credit->days_to <= 10 ? 'text-warning' : 'text-success') }}">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ Helper::paymentStatus($credit->days_to) }}</td>
                                    </tr>
                                    <tr class="mb-3">
                                        <td colspan="2">
                                            <div class="progress" style="height: 2px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $credit->balance_payed / $credit->credit->amount * 100 }}%;" aria-valuenow="{{ $credit->balance_payed / $credit->credit->amount * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <div class="text-center p-2 mb-2 mt-2 bg-light bg-gradient text-success rounded">{{ __('У вас нет текущих кредитов') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        @enddesktop

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('credit.create') }}" class="btn btn-primary rounded">{!! Icons::get(Icons::CREATE) !!}&nbsp&nbsp;{{ __('Добавить кредит') }}</a>
                        </div>

                        @desktop
                            <table class="table table-bordered mt-3 admin-table__adapt admin-table__instrument caption-top">
                                <caption>{{ __('Сальдо по всем кредитам') }}</caption>
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-start">{!! Icons::get(Icons::CURRENCY) !!} {{ __('Валюта') }}</th>
                                        <th class="text-end">{{ __('Всего кредитов') }}</th>
                                        <th class="text-end">{{ __('Сумма кредитов') }}</th>
                                        <th class="text-end">{{ __('Выплачено долга') }}</th>
                                        <th class="text-end">{{ __('Остаток долга') }}</th>
                                        <th class="text-end">{{ __('Платежей в месяц') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($saldo as $currency => $data)
                                        <tr class="align-middle">
                                            <td data-label="{{ __('Валюта') }}" class="text-start">{{ $currency }}</td>
                                            <td data-label="{{ __('Всего кредитов') }}" class="text-end">{{ $data['count'] ?? 0 }}</td>
                                            <td data-label="{{ __('Сумма кредитов') }}" class="text-end">{{ number_format($data['amount'], 0, '.', ' ') }} {{ $currency }}</td>
                                            <td data-label="{{ __('Выплачено долга') }}" class="text-end">{{ number_format($data['payed'], 0, '.', ' ') }} {{ $currency }}</td>
                                            <td data-label="{{ __('Остаток долга') }}" class="text-end">{{ number_format($data['debt'], 0, '.', ' ') }} {{ $currency }}</td>
                                            <td data-label="{{ __('Платежей в месяц') }}" class="text-end">{{ number_format($data['payments'], 0, '.', ' ') }} {{ $currency }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center p-2 mb-2 bg-light bg-gradient text-success rounded">{{ __('Кредитов не найдено') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @elsedesktop
                            <table class="table table-borderless mt-3">
                                <tr class="table-secondary border-bottom border-top">
                                    <td colspan="2" class="text-center bg-light"> Сальдо по кредитам</td>
                                </tr>
                                @forelse($saldo as $currency => $data)
                                    <tr>
                                        <td class="text-start">{!! Icons::get(Icons::COUNTER) !!} Кредитов</td>
                                        <td class="text-end">{{ $data['count'] ?? 0 }} на {{ number_format($data['amount'], 0, '.', ' ') }} {{ $currency }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">{!! Icons::get(Icons::WAS_PAYED) !!} Выплачено</td>
                                        <td class="text-end">{{ number_format($data['payed'], 0, '.', ' ') }} {{ $currency }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">{!! Icons::get(Icons::WILL_PAY) !!} Остаток</td>
                                        <td class="text-end">{{ number_format($data['debt'], 0, '.', ' ') }} {{ $currency }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-start">{!! Icons::get(Icons::PAYMENT_OVERDUE) !!} Фин. нагрузка</td>
                                        <td class="text-end">{{ number_format($data['payments'], 0, '.', ' ') }} {{ $currency }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <div class="text-center p-2 mb-2 mt-2 bg-light bg-gradient text-success rounded">{{ __('У вас нет текущих кредитов') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        @enddesktop

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
