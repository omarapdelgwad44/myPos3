<!-- Edit Clint Modal -->
<div class="modal fade" id="editClintModal" tabindex="-1" aria-labelledby="editClintModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClintModalLabel">{{ trans('adminlte::adminlte.edit_clint') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editClintForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editClintId" name="id">

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="editClintName" class="form-label">{{ trans('adminlte::adminlte.name') }}</label>
                        <input type="text" class="form-control" id="editClintName" name="name" required>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="editClintAddress" class="form-label">{{ trans('adminlte::adminlte.address') }}</label>
                        <input type="text" class="form-control" id="editClintAddress" name="address" required>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="editClintPhone" class="form-label">{{ trans('adminlte::adminlte.phone') }}</label>
                        <input type="text" class="form-control" id="editClintPhone" name="phone" required>
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

<script>
    function openEditModal(clintId, name, address, phone) {
        document.getElementById('editClintId').value = clintId;
        document.getElementById('editClintName').value = name;
        document.getElementById('editClintAddress').value = address;
        document.getElementById('editClintPhone').value = phone;

        document.getElementById('editClintForm').action = `/dashboard/clints/${clintId}`;
        new bootstrap.Modal(document.getElementById('editClintModal')).show();
    }
</script>
