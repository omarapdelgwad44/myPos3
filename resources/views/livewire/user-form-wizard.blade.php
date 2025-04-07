<div>
    <div class="steps mb-3">
        <strong>Step {{ $step }} of 4</strong>
    </div>

    @if($step == 1)
        <div>
            <label>{{ __('adminlte::adminlte.name') }}</label>
            <input type="text" wire:model.debounce.500ms="name" class="form-control" id="name-field">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror

            <label>{{ __('adminlte::adminlte.email') }}</label>
            <input type="email" wire:model.debounce.500ms="email" class="form-control" id="email-field">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    @elseif($step == 2)
        <div>
            <label>{{ __('adminlte::adminlte.image') }}</label>
            <input type="file" wire:model="image" class="form-control">
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror

            @if ($imagePreview)
                <img src="{{ $imagePreview }}" alt="Preview" style="max-width: 200px;" class="mt-2">
            @endif
        </div>
    @elseif($step == 3)
        <div>
            <label>{{ __('adminlte::adminlte.password') }}</label>
            <input type="password" wire:model.debounce.500ms="password" class="form-control" id="password-field">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror

            <label>{{ __('adminlte::adminlte.confirm_password') }}</label>
            <input type="password" wire:model.debounce.500ms="password_confirmation" class="form-control" id="password-confirm-field">
        </div>
    @elseif($step == 4)
        <div>
            <label>{{ __('adminlte::adminlte.permissions') }}</label>
            @foreach($allPermissions as $perm)
                <div class="form-check">
                    <input type="checkbox" wire:model="permissions" value="{{ $perm->id }}" id="perm-{{ $perm->id }}">
                    <label for="perm-{{ $perm->id }}">{{ $perm->name }}</label>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-4 d-flex justify-content-between">
        @if($step > 1)
            <button wire:click="previousStep" class="btn btn-secondary">{{ __('adminlte::adminlte.back') }}</button>
        @endif

        @if($step < 4)
            <button wire:click="nextStep" class="btn btn-primary">{{ __('adminlte::adminlte.next') }}</button>
        @else
            <button wire:click="store" class="btn btn-success">{{ __('adminlte::adminlte.create_user') }}</button>
        @endif
    </div>
</div>