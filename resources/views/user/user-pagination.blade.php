<table class="table align-middle" id="user-table" style="width: 100%;">
    <thead>
    <tr>
        <th>#</th>
        <th>Profile</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>BOD</th>
        <th>Age</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tbody class="user-table-body">
    @if(count($users) > 0)
        @foreach($users as $key => $user)
            <tr class="align-bottom">
                <td>{{$key+1}}</td>
                <td>
                    @if(!empty($user->profile))
                        <img src="{{asset('profile_image/'.$user->profile)}}" width="50px" height="auto">
                    @endif
                </td>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->mobile_number}}</td>
                <td>{{\Illuminate\Support\Carbon::make($user->bod)->format('d-m-Y')}}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($user->bod)->diffForHumans() }}</td>
                <td>
                    @if($user->status == 1)
                        <button type="button" class="btn btn-sm btn-primary">Active</button>
                    @else
                        <button type="button" class="btn btn-sm btn-danger">Inactive</button>
                    @endif
                </td>
                <td>{{\Illuminate\Support\Carbon::make($user->created_at)->format('d-m-Y')}}</td>
                <td>
                    <button class="btn" onclick="editUser({{$user->id}})"><i class="fa fa-edit"></i>
                    </button>
                    <button class="btn" onclick="deleteUser({{$user->id}})"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="12" class="text-center"><i class="fa fa-exclamation-triangle"></i>&nbsp;data not available!
            </td>
        </tr>
    @endif
    </tbody>
</table>
{!! $users->links() !!}

