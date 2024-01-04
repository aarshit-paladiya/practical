@extends('layout.app')
@section('title') User List @endsection
@section('content')
    <style>
        .card.user-card {
            background-color: #fff; /* Card background color */
            border: 1px solid #ddd; /* Border color */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle lift */
            padding: 15px;
            margin-bottom: 20px;
        }

        .card.user-card img {
            max-height: 200px; /* Limit the height of the user image */
            object-fit: cover; /* Maintain aspect ratio and cover the container */
            border-radius: 8px; /* Rounded corners for the image */
        }

        .card.user-card .card-footer {
            background-color: #f8f9fa; /* Footer background color */
            border-top: 1px solid #ddd; /* Border color for the footer */
            border-radius: 0 0 10px 10px; /* Rounded corners for the bottom */
        }

        .card.user-card .badge {
            margin-right: 5px; /* Adjust spacing for status badge */
        }

    </style>
    <div class="row mt-4">
        <div class="col-3">
            <label for="search_filter">Search</label>
            <input type="text" id="search_filter" name="search_filter" class="form-controller">
        </div>
        <div class="col-2">
            <label for="">Status</label>
            <select class="" name="status_filter" id="status_filter">
                <option value="">All</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 " id="user-card-list">
        @include('user-list.ajax-paginate-user')
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let status = $('#status_filter').val();
            let search = $('#search_filter').val();
            record(page, search, status);
        });

        function record(page, search, status) {
            $.ajax({
                url: '{{route('user-lists.index')}}' + '/?page=' + page,
                data: {
                    search: search,
                    status: status
                },
                success: function (users) {
                    $('#user-card-list').html(users);
                }
            });
        }

        function fetchDataFilter(status) {
            $.ajax({
                url: '{{route('user-lists.index')}}',
                data: {
                    status: status,
                },
                success: function (res) {
                    $('#user-card-list').html(res);
                }
            })
        }

        function handleFilter() {
            let status = $('#status_filter').val();
            fetchDataFilter(status);
        }

        $('#status_filter').on('change', handleFilter);

        function fetchSearchFilter(search) {
            $.ajax({
                url: '{{route('user-lists.index')}}',
                data: {
                    search: search
                },
                success: function (res) {
                    $('#user-card-list').html(res);
                }
            })
        }

        $('#search_filter').on('input', function () {
            let search = $(this).val();
            fetchSearchFilter(search);
        });
    </script>
@endpush
