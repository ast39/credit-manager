@php
    use App\Libs\Icons;
    use Illuminate\Support\Facades\Lang;
@endphp

@extends('layouts.app')

@section('title', __('История расчета кредитов'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-primary text-white">
                    <div class="card-header">{{ __('Мои расчеты кредитов') }}</div>

                    <div class="card-body bg-white">

                        @desktop
                            <table class="table table-bordered admin-table__adapt admin-table__instrument">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-start">{!! Icons::get(Icons::TITLE) !!} Название</th>
                                        <th class="text-center">{!! Icons::get(Icons::CURRENCY) !!} Валюта</th>
                                        <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} Сумма</th>
                                        <th class="text-center">{!! Icons::get(Icons::PERCENT) !!} Процент</th>
                                        <th class="text-center">{!! Icons::get(Icons::PERIOD) !!} Срок</th>
                                        <th class="text-end">{!! Icons::get(Icons::BALANCE_START) !!} Платеж</th>
                                        <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($credits as $credit)
                                        <tr>
                                            <td data-label="Название" class="text-start"><a class="text-decoration-none text-primary" href="{{ route('credit.calc.show', $credit->credit_id) }}">{{ $credit->title ?? '' }}</a></td>
                                            <td data-label="Валюта" class="text-center">{{ $credit->currency->abbr ?? '' }}</td>
                                            <td data-label="Сумма" class="text-end">{{ is_null($credit->amount) ? '???' : number_format($credit->amount, 0, '.', ' ') . ' ' . $credit->currency->abbr }}</td>
                                            <td data-label="Процент" class="text-center">{{ is_null($credit->percent) ? '???' : number_format($credit->percent, 2, '.', ' ') }}</td>
                                            <td data-label="Срок" class="text-center">{{ is_null($credit->period) ? '???' : $credit->period . ' ' . Lang::choice('месяц|месяца|месяцев', $credit->period) }}</td>
                                            <td data-label="Платеж" class="text-end">{{ is_null($credit->payment) ? '???' : number_format($credit->payment, 0, '.', ' ') . ' ' . $credit->currency->abbr }}</td>
                                            <td data-label="Действия" class="text-end">
                                                <form method="post" action="{{ route('credit.calc.destroy', $credit->credit_id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="mmot-table__action">
                                                        <a title="Открыть" href="{{ route('credit.calc.show', $credit->credit_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-view"></use></svg></a>
                                                        <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('Вы уверены, что хотите удалить расчет?')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет истории расчетов') }}</div>
                                    @endforelse
                                </tbody>
                            </table>
                        @elsedesktop
                            <table class="table table-borderless">
                                @forelse($credits as $credit)
                                    <tr>
                                        <td colspan="3" class="text-start">{!! Icons::get(Icons::TITLE) !!} <a class="text-decoration-none text-primary" href="{{ route('credit.calc.show', $credit->credit_id) }}">{{ $credit->title ?? '' }}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">{!! Icons::get(Icons::PERIOD) !!} {{ is_null($credit->period) ? '???' : $credit->period . ' ' . Lang::choice('месяц|месяца|месяцев', $credit->period) }}</td>
                                        <td class="text-center">{!! Icons::get(Icons::PERCENT) !!} {{ is_null($credit->percent) ? '???' : number_format($credit->percent, 2, '.', ' ') }}</td>
                                        <td class="text-end">{!! Icons::get(Icons::PAYMENT) !!} {{ is_null($credit->payment) ? '???': number_format($credit->payment, 0, '.', ' ') . ' ' . $credit->currency->abbr }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td  colspan="2" class="text-start">{!! Icons::get(Icons::AMOUNT) !!} {{ is_null($credit->amount) ? '???' : number_format($credit->amount, 0, '.', ' ') . ' ' . $credit->currency->abbr }}</td>
                                        <td class="text-end">
                                            <form method="post" action="{{ route('credit.calc.destroy', $credit->credit_id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <div class="mmot-table__action">
                                                    <a title="Открыть" href="{{ route('credit.calc.show', $credit->credit_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-view"></use></svg></a>
                                                    <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('Вы уверены, что хотите удалить расчет?')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <div class="text-center p-2 mb-2 mt-2 bg-light bg-gradient text-success rounded">{{ __('У вас нет расчетов в истории') }}</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        @enddesktop

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('credit.calc.create') }}" class="btn btn-primary rounded">{!! Icons::get(Icons::CREATE) !!}&nbsp;{{ __('Новый расчет') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
