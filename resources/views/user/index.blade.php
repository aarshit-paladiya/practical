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
                <div class="card-header text-uppercase">
                    <b>User Crud Operation Without Refresh Page</b>
                </div>
                <div class="row">
                    <div class="col-3 m-2">
                        <label for="search_filter">Search</label>
                        <input class="form-control" type="text" id="search_filter" name="search_filter"
                               placeholder="search...." value="">
                    </div>
                    <div class="col-2 m-2">
                        <label for="start_date_filter">Start Date</label>
                        <input class="form-control" type="date" id="start_date_filter" name="start_date_filter">
                    </div>
                    <div class="col-2 m-2">
                        <label for="end_date_filter">To Date</label>
                        <input class="form-control" type="date" id="end_date_filter" name="end_date_filter">
                    </div>
                    <div class="col-2 m-2">
                        <label for="status_filter">Status</label>
                        <select class="form-select" id="status_filter" name="status_filter">
                            <option value="">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-1 mt-3">
                        <a href="{{route('users.index')}}" class="btn btn-outline-danger btn-sm mt-3"><i
                                class="fa fa-refresh"></i></a>
                    </div>
                </div>
                <hr>
                <div class="card-body table-card-body table-responsive">
                    @include('user.user-pagination')
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-xl fade" id="userModel" tabindex="-1" aria-labelledby="userModelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="user-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"></h5>
                        <div class="col-10 d-flex justify-content-end">
                            <div class="form-check form-switch form-check-lg">
                                <input type="checkbox" class="form-check-input" style="width: 50px;height: 30px"
                                       id="status"
                                       name="status" checked>
                                <label for="status" class="ms-2">Status</label>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="profile-image mt-2"><img src="" width="50px" height="auto"></div>
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <div class="col-12">
                                <label for="profile">Profile<span class="text-danger">*</span></label>
                                <input type="file" class="form-control"
                                       id="profile" name="profile">
                            </div>
                            <div class="col-6">
                                <label for="first_name">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                       id="first_name" name="first_name"
                                       value="{{old('first_name')}}"
                                       placeholder="Enter first name">
                            </div>
                            <div class="col-6">
                                <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                       id="last_name" name="last_name"
                                       value="{{old('last_name')}}"
                                       placeholder="Enter last name">
                            </div>
                            <div class="col-6">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control"
                                       id="email" name="email"
                                       value="{{old('email')}}"
                                       placeholder="Enter email name">
                            </div>
                            <div class="col-6">
                                <label for="password">Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control"
                                       id="password" name="password"
                                       value="{{old('email')}}"
                                       placeholder="Enter password">
                                <span class="text-danger"
                                      id="blank_password">If you don't want to change, blank it.</span>
                            </div>
                            <div class="col-6">
                                <label for="mobile_number">Mobile No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                       id="mobile_number" name="mobile_number"
                                       value="{{old('mobile_number')}}"
                                       placeholder="Enter mobile number name">
                            </div>
                            <div class="col-6">
                                <label for="bod">Birth Of Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control"
                                       id="bod" name="bod">
                            </div>


                        </div>
                    </div>
                </form>
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
        let currentPage = 1;
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            currentPage = parseInt(page);
            let search = $('#search_filter').val();
            let startDate = $('#start_date_filter').val();
            let endDate = $('#end_date_filter').val();
            let status = $('#status_filter').val();
            record(page, search, startDate, endDate, status);
        });

        function record(page, search, startDate, endDate, status) {
            $.ajax({
                url: "users/?page=" + page,
                data: {
                    search: search,
                    startDate: startDate,
                    endDate: endDate,
                    status: status,
                },
                success: function (users) {
                    $('.table-card-body').html(users);
                }
            })
        }

        function updatePagination() {
            record(currentPage);
        }

        function createPagination() {
            let page = 1;
            record(page);
        }

        let search = $('#search_filter').val();
        searchFilter(search);

        function searchFilter(search) {
            $.ajax({
                type: 'get',
                url: '{{route('users.index')}}',
                data: {
                    search: search,
                },
                success: function (users) {
                    $('.table-card-body').html(users);
                }
            });
        }

        $('#search_filter').on('input', function () {
            let search = $(this).val();
            searchFilter(search);
        });

        function dateFilter(startDate, endDate, status) {
            $.ajax({
                type: 'get',
                url: '{{route('users.index')}}',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    status: status,
                },
                success: function (users) {
                    $('.table-card-body').html(users);
                }
            });
        }

        function handleDateFilter() {
            let startDate = $('#start_date_filter').val();
            let endDate = $('#end_date_filter').val();
            let status = $('#status_filter').val();
            dateFilter(startDate, endDate, status);
        }

        $('#start_date_filter, #end_date_filter,#status_filter').on('change', handleDateFilter);


        function addUser(userId) {
            let inputInvalid = $('#user-form').find('.is-invalid');
            inputInvalid.removeClass('is-invalid');
            $('.error-message').remove();
            $('#title').text('Add New User');
            $('#user_id').val(userId);
            $('#first_name').val('');
            $('#last_name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#mobile_number').val('');
            $('#bod').val('');
            $('.profile-image').hide();
            $('#status').prop('checked', true);
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
                        $('.profile-image').show();
                        let imageUrl = '{{ config('app.url') }}/profile_image/' + response.data.profile;
                        $('.profile-image img').attr('src', imageUrl);
                        $('#user_id').val(response.data.id);
                        $('#first_name').val(response.data.first_name);
                        $('#last_name').val(response.data.last_name);
                        $('#email').val(response.data.email);
                        $('#mobile_number').val(response.data.mobile_number);
                        $('#bod').val(response.data.bod);
                        if (response.data.status == '1') {
                            $('#status').prop('checked', true);
                        } else {
                            $('#status').prop('checked', false);
                        }
                        $('#password').val('');
                        $('#blank_password').show();
                        $('#action-button').text('Update');
                        $('#userModel').modal('show');
                    },
                })
            }
        }

        function submitUser() {
            let formData = new FormData($('#user-form')[0]);
            $.ajax({
                type: 'post',
                url: '{{ route('users.store') }}',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                    } else {
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
