<!-- Add Clint Modal -->
<div class="modal fade" id="addClintModal" tabindex="-1" aria-labelledby="addClintModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClintModalLabel">{{ trans('adminlte::adminlte.add_clint') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.clints.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ trans('adminlte::adminlte.name') }}:</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">{{ trans('adminlte::adminlte.address') }}:</label>
                        <input type="text" name="address" id="address" class="form-control" required value="{{ old('address') }}">
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ trans('adminlte::adminlte.phone') }}:</label>
                        <input type="text" name="phone" id="phone" class="form-control" required value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('adminlte::adminlte.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('adminlte::adminlte.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
