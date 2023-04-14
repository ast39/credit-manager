@php
    use App\Libs\Icons;
@endphp

@extends('layouts.app')

@section('title', __('История расчета вкладов'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Мои расчеты вкладов') }}</div>

                    <div class="card-body">

                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-start">{!! Icons::get(Icons::TITLE) !!} Название</th>
                                    <th class="text-end">{!! Icons::get(Icons::BALANCE) !!} Сумма</th>
                                    <th class="text-start">{!! Icons::get(Icons::CURRENCY) !!} Валюта</th>
                                    <th class="text-center">{!! Icons::get(Icons::PERCENT) !!} Процент</th>
                                    <th class="text-center">{!! Icons::get(Icons::PERIOD) !!} Срок</th>
                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $deposit)
                                    <tr>
                                        <td data-label="#"><b>{{ $loop->iteration }}</b></td>
                                        <td data-label="Название" class="text-start"><a class="text-decoration-none text-primary" href="{{ route('deposit.calc.show', $deposit->deposit_id) }}">{{ $deposit->title ?? '' }}</a></td>
                                        <td data-label="Сумма" class="text-end">{{ $deposit->amount ?? '' }}</td>
                                        <td data-label="Валюта" class="text-start">{{ $deposit->currency ?? '' }}</td>
                                        <td data-label="Процент" class="text-center">{{ $deposit->percent ?? 0 }}%</td>
                                        <td data-label="Срок" class="text-center">{{ $deposit->period }} (в месяцах)</td>
                                        <td data-label="Действия" class="text-end">
                                            <form method="post" action="{{ route('deposit.calc.destroy', $deposit->deposit_id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <a title="Открыть" href="{{ route('deposit.calc.show', $deposit->deposit_id) }}" class="btn btn-sm btn-primary me-1"><i class="bi bi-text-center" style="font-size: 1rem"></i></a>
                                                <button type="submit" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить расчет?')" class="btn btn-sm btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет истории расчетов') }}</div>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('deposit.calc.create') }}" class="btn btn-primary">{!! Icons::get(Icons::CREATE) !!} {{ __('Новый расчет') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
