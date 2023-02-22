@props(['failed','errors', 'status', 'success'])

@if ($success)
<div {{ $attributes->merge(['class' => 'toast-container p-3']) }}>
	<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<i class="ti ti-circle-check text-success me-2 fs-3"></i>
			<strong class="me-auto">Success</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
      {{ $success }}
    </div>
	</div>
</div>
@endif

@if ($failed)
<div {{ $attributes->merge(['class' => 'toast-container p-3']) }}>
	<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<i class="ti ti-circle-check text-danger me-2 fs-3"></i>
			<strong class="me-auto">Failed</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
      {{ $failed }}
    </div>
	</div>
</div>
@endif

@if ($status)
<div {{ $attributes->merge(['class' => 'toast-container p-3']) }}>
	<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<i class="ti ti-alert-info-circle text-danger me-2 fs-3"></i>
			<strong class="me-auto">Notification</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
      {{ $status }}
    </div>
	</div>
</div>
@endif

@if ($errors->any())
<div {{ $attributes->merge(['class' => 'toast-container p-3']) }}>
	<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<i class="ti ti-alert-triangle text-danger me-2 fs-3"></i>
			<strong class="me-auto">{{ __('Whoops! Something went wrong.') }}</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
	</div>
</div>
@endif


