@php
    use App\Libs\Icons;
@endphp

<form method="get" action="{{ route('credit.index', $sortable) }}" data-filterline__sandwich>
    <label for="currency" class="form-label">{!! Icons::get(Icons::FILTER) !!} {{ __('Фильтры') }}</label>
    <div class="mmot-filterline__sandwich dselect-wrapper" data-filterline_sandwich_parent="filter_planing">
        <div class="mmot-filterline__sandwich__head form-select">Настройки фильтра</div>
    </div>

    <div class="mmot-filterline-justify mmot-filterline__sandwich__list hide" data-filterline_sandwich_child="filter_planing">
        <div class="mmot-filterline">
            <div class="mmot-filterline">

                <div class="mmot-filterline__one" data-input_clear_content>
                    <select name="currency" id="currency" class="form-select form-control">
                        <option title="{{ __('Валюта') }}" {{ (request()->currency ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Валюта') }}</option>
                        @forelse($currencies as $currency)
                            <option title="{{ $currency->title }}" {{ (request()->currency ?? 0) == $currency->currency_id ? 'selected' : '' }} value="{{ $currency->currency_id }}">{{ $currency->title }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="mmot-filterline__one" data-input_clear_content>
                    <input type="text" name="title" id="title" class="form-control" value="{{ request('title') }}" placeholder="{{ __('Название') }}" data-input_clear>
                </div>

                <div class="mmot-filterline__one" data-input_clear_content>
                    <input type="text" name="bank" id="bank" class="form-control" value="{{ request('bank') }}" placeholder="{{ __('Банк') }}" data-input_clear>
                </div>

            </div>
        </div>

        <div class="mmot-filterline">
            <div class="mmot-filterline__one">
                <a href="{{ route('credit.index') }}" type="button" class="btn btn-secondary w block">{{ __('Сбросить') }}</a>
            </div>

            <div class="mmot-filterline__one">
                <button type="submit" class="btn btn-primary block">{{ __('Показать') }}</button>
            </div>
        </div>
    </div>
</form>
