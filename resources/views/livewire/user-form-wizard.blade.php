<div class="user-wizard-container">
    <!-- Progress bar -->
    <div class="wizard-progress mb-4">
        <div class="progress">
            <div class="progress-bar bg-gradient-primary" role="progressbar" 
                style="width: {{ ($step / $totalSteps) * 100 }}%" 
                aria-valuenow="{{ ($step / $totalSteps) * 100 }}" 
                aria-valuemin="0" 
                aria-valuemax="100"></div>
        </div>
        <div class="step-indicators d-flex justify-content-between">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <div class="step-indicator {{ $i <= $step ? 'active' : '' }} {{ $i < $step ? 'completed' : '' }}">
                    <div class="step-icon">
                        @if ($i < $step)
                            <i class="fas fa-check"></i>
                        @else
                            {{ $i }}
                        @endif
                    </div>
                    <div class="step-label">
                        @switch($i)
                            @case(1)
                                {{ __('adminlte::adminlte.basic_info') }}
                                @break
                            @case(2)
                                {{ __('adminlte::adminlte.profile') }}
                                @break
                            @case(3)
                                {{ __('adminlte::adminlte.security') }}
                                @break
                            @case(4)
                                {{ __('adminlte::adminlte.permissions') }}
                                @break
                        @endswitch
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-gradient-primary text-white">
            <h4 class="m-0">{{ __('adminlte::adminlte.create_user') }} - 
                @switch($step)
                    @case(1)
                        {{ __('adminlte::adminlte.basic_info') }}
                        @break
                    @case(2)
                        {{ __('adminlte::adminlte.profile') }}
                        @break
                    @case(3)
                        {{ __('adminlte::adminlte.security') }}
                        @break
                    @case(4)
                        {{ __('adminlte::adminlte.permissions') }}
                        @break
                @endswitch
            </h4>
        </div>

        <div class="card-body p-4">
            <form wire:submit.prevent="store">
                @if($step == 1)
                    <div class="form-step">
                        <div class="form-group">
                            <label for="name-field">
                                <i class="fas fa-user mr-1"></i>
                                {{ __('adminlte::adminlte.name') }}
                            </label>
                            <input type="text" 
                                   wire:model.debounce.500ms="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name-field"
                                   placeholder="{{ __('adminlte::adminlte.name') }}">
                            @error('name') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email-field">
                                <i class="fas fa-envelope mr-1"></i>
                                {{ __('adminlte::adminlte.email') }}
                            </label>
                            <input type="email" 
                                   wire:model.debounce.500ms="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email-field"
                                   placeholder="{{ __('adminlte::adminlte.email') }}">
                            @error('email') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @elseif($step == 2)
                    <div class="form-step">
                        <div class="form-group">
                            <label for="image-upload">
                                <i class="fas fa-camera mr-1"></i>
                                {{ __('adminlte::adminlte.profile_image') }}
                            </label>
                            
                            <div class="custom-file">
                                <input type="file" 
                                       wire:model="image" 
                                       class="custom-file-input @error('image') is-invalid @enderror" 
                                       id="image-upload">
                                <label class="custom-file-label" for="image-upload">
                                    {{ $image ? $image->getClientOriginalName() : __('adminlte::adminlte.choose_file') }}
                                </label>
                                @error('image') 
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="image-preview-container mt-3 text-center">
                                @if ($imagePreview)
                                    <img src="{{ $imagePreview }}" alt="Profile Preview" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="image-placeholder rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                                        <i class="fas fa-user fa-3x text-secondary"></i>
                                    </div>
                                @endif
                                
                                <div class="image-upload-note mt-2 text-muted">
                                    <small>{{ __('adminlte::adminlte.image_preview') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($step == 3)
                    <div class="form-step">
                        <div class="form-group">
                            <label for="password-field">
                                <i class="fas fa-lock mr-1"></i>
                                {{ __('adminlte::adminlte.password') }}
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       wire:model.debounce.500ms="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password-field">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password-field')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password') 
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">{{ __('adminlte::adminlte.password_requirements') }}</small>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm-field">
                                <i class="fas fa-lock mr-1"></i>
                                {{ __('adminlte::adminlte.confirm_password') }}
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       wire:model.debounce.500ms="password_confirmation" 
                                       class="form-control" 
                                       id="password-confirm-field">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password-confirm-field')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($step == 4)
                    <div class="form-step">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-shield-alt mr-1"></i>
                                {{ __('adminlte::adminlte.user_permissions') }}
                            </label>
                            
                            <div class="permissions-container">
                                <div class="row">
                                    @foreach($allPermissions as $perm)
                                        <div class="col-md-4 mb-2">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" 
                                                       wire:model="permissions" 
                                                       value="{{ $perm->id }}" 
                                                       class="custom-control-input" 
                                                       id="perm-{{ $perm->id }}">
                                                <label class="custom-control-label" for="perm-{{ $perm->id }}">
                                                    {{ $perm->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="permissions-summary mt-3">
                                <div class="badge badge-primary p-2">
                                    {{ count($permissions) }} {{ __('adminlte::adminlte.permissions_selected') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="wizard-buttons mt-4 d-flex justify-content-between">
                    @if($step > 1)
                        <button type="button" wire:click="previousStep" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> {{ __('adminlte::adminlte.back') }}
                        </button>
                    @else
                        <div></div> <!-- Empty div to maintain spacing -->
                    @endif

                    @if($step < $totalSteps)
                        <button type="button" wire:click="nextStep" class="btn btn-primary">
                            {{ __('adminlte::adminlte.next') }} <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    @else
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus mr-1"></i> {{ __('adminlte::adminlte.create_user') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
</script>