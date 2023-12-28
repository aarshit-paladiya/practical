<table class="table table-striped align-middle" id="user-table" style="width: 100%;">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tbody class="user-table-body">
    @foreach($users as $key => $user)
        <tr class="align-bottom">
            <td>{{$key+1}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <button class="btn" onclick="editUser({{$user->id}})"><i class="fa fa-edit"></i>
                </button>
                <button class="btn" onclick="deleteUser({{$user->id}})"><i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $users->links() !!}

