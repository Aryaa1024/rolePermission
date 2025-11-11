@extends('templates.template1.admin.master.app')

@push('app-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Manage Roles & Permissions</h4>
                    @can('admin.rolepermissions.store')
                        <button class="btn btn-primary btn-sm" id="addRoleBtn">Add Role</button>
                    @endcan
                </div>
                <table class="table table-bordered" id="roleTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="roleForm">
                    @csrf
                    <input type="hidden" name="roleId" id="roleId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Role Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="mb-3">
                            <label>Assign Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input permission-checkbox"
                                                name="permissions[]" value="{{ $permission->name }}"
                                                id="perm_{{ $permission->id }}">
                                            <label class="form-check-label"
                                                for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('app-script')
    <script>
        $(document).ready(function() {
            let table = $('#roleTable').DataTable({
                ajax: "{{ route('admin.rolepermissions.index') }}",
                columns: [{
                        data: null
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'permissions',
                        render: data => data.map(p =>
                            `<span class="badge bg-info mb-2">${p.name}</span>`).join(' ')
                    },
                    {
                        data: null
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // 👇 use Blade to inject button templates
                    let actions = `
                    @can('admin.rolepermissions.edit')
                        <button class="btn btn-sm btn-warning editBtn me-1" data-id="${data.id}">Edit</button>
                    @endcan
                    @can('admin.rolepermissions.delete')
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.id}">Delete</button>
                    @endcan
                `;

                    $('td', row).eq(0).html(dataIndex + 1);
                    $('td', row).eq(3).html(actions || '-');
                }
            });

            // ✅ Add Role
            $('#addRoleBtn').click(function() {
                $('#roleForm')[0].reset();
                $('#roleId').val('');
                $('#roleModalLabel').text('Add Role');
                $('.permission-checkbox').prop('checked', false);
                $('#roleModal').modal('show');
            });

            // ✅ Edit Role
            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.rolepermissions.edit', ':id') }}".replace(':id', id);
                $.get(url, function(res) {
                    if (res.status) {
                        $('#roleForm')[0].reset();
                        $('#roleId').val(res.role.id);
                        $('#name').val(res.role.name);
                        $('.permission-checkbox').prop('checked', false);
                        res.role.permissions.forEach(p => {
                            $(`input[value='${p.name}']`).prop('checked', true);
                        });
                        $('#roleModalLabel').text('Edit Role');
                        $('#roleModal').modal('show');
                    }
                });
            });

            // ✅ Save Role (Create/Update)
            $('#roleForm').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.rolepermissions.store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Success', res.message, 'success');
                            $('#roleModal').modal('hide');
                            table.ajax.reload();
                        } else {
                            $('.error-name').text(res.errors?.name ?? '');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            });

            // ✅ Delete Role
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.rolepermissions.delete', ':id') }}"
                                .replace(':id', id),
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire('Deleted!', res.message, 'success');
                                    table.ajax.reload();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
