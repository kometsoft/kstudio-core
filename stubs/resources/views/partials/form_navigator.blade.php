@if (!empty($navigators))
    <x-forms.dropdown name="navigator" width="12" class="navigator" divClass="input-field pe-2" :options="$navigators"
        placeholder="{{ __('Form Navigator') }}">

    </x-forms.dropdown>
@endif
