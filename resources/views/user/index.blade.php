@extends('layout.app')
@section('title') Users @endsection
@section('content')
    <div class="row mt-4" id="user-page-search">
        <div class="col-12">
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
        </div>
        <div class="col-12 mb-2 d-flex justify-content-end">
            <button class="btn btn-primary text-uppercase" onclick="addUser('0')">Add User</button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    User Crud Operation Without Refresh Page
                </div>
                <div class="card-body table-card-body table-responsive">
                    @include('user.user-pagination')
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-xl fade" id="userModel" tabindex="-1" aria-labelledby="userModelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="" id="user-form">
                        <div class="row">
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control"
                                       id="name" name="name"
                                       value="{{old('name')}}"
                                       placeholder="Enter user name">
                            </div>
                            <div class="col-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control"
                                       id="email" name="email"
                                       value="{{old('email')}}"
                                       placeholder="Enter email name">
                            </div>
                            <div class="col-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control"
                                       id="password" name="password"
                                       value="{{old('email')}}"
                                       placeholder="Enter password name">
                                <span class="text-danger"
                                      id="blank_password">If you don't want to change, blank it.</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUser()" id="action-button"></button>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')

    <script type="text/javascript">
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            record(page);
        });

        function record(page) {
            $.ajax({
                url: "users/?page=" + page,
                success: function (users) {
                    $('.table-card-body').empty().html(users);
                }
            })
        }

        function addUser(userId) {
            let inputInvalid = $('#user-form').find('.is-invalid');
            inputInvalid.removeClass('is-invalid');
            $('.error-message').remove();
            $('#title').text('Add New User');
            $('#user_id').val(userId);
            $('#name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#blank_password').hide();
            $('#action-button').text('Submit');
            $('#userModel').modal('show')
        }

        function editUser(userId) {
            if (userId) {
                $.ajax({
                    type: 'post',
                    url: '{{route('users.fetch.user.edit')}}',
                    data: {
                        user_id: userId,
                        _token: "{{csrf_token()}}"
                    },
                    success: function (response) {
                        let inputInvalid = $('#user-form').find('.is-invalid');
                        inputInvalid.removeClass('is-invalid');
                        $('.error-message').remove();
                        $('#title').text('Edit User');
                        $('#user_id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#password').val('');
                        $('#blank_password').show();
                        $('#action-button').text('Update');
                        $('#userModel').modal('show');
                    },
                })
            }
        }

        function submitUser() {
            let formArray = $('#user-form').serializeArray();
            let formData = {};

            $.each(formArray, function (i, field) {
                formData[field.name] = field.value;
            });

            $.ajax({
                type: 'post',
                url: '{{route('users.store')}}',
                data: {
                    ...formData,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.status) {
                        toastr.success(response.message);
                        $('#userModel').modal('hide');
                        if (response.data == '0') {
                            createPagination();
                        } else {
                            updatePagination();
                        }
                    }else{
                        toastr.error(response.message);
                    }
                },
                error: function (error) {
                    let errors = error.responseJSON.errors;
                    showErrorModal(errors);
                }
            })
        }

        function showErrorModal(errors) {
            $('#user-form .form-control').removeClass('is-invalid');
            $('.error-message').remove();
            $.each(errors, function (field, messages) {
                let inputField = $('#user-form').find('[name="' + field + '"]');
                inputField.addClass('is-invalid');
                inputField.after('<span class="text-danger error-message">' + messages.join('<br>') + '</span>');
            });
            $('#userModel').modal('show');
        }

        function updatePagination() {
            let page = $('.pagination a').attr('href').split('page=')[1];
            let currentPage = 1;
            if (page == '2') {
                console.log('plus');
                currentPage = parseInt(page) - 1;
            } else {
                console.log('minus');
                currentPage = parseInt(page) + 1;
            }
            record(currentPage);
        }

        function createPagination() {
            let page = 1;
            record(page);
        }

        function deleteUser(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '{{route('users.delete')}}',
                        data: {
                            userId: userId,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                updatePagination();
                            } else {
                                swal.fire({
                                    text: response.message,
                                    icon: "warning",
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endpush
