@if(count($users) > 0)
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            {{$users->links()}}
        </div>
    </div>
    @foreach($users as $user)
        <div class="col-md-4 mb-4">
            <div class="card user-card">
                <img height="200px" src="{{ asset('profile_image/'.$user->profile) }}" class="card-img-top"
                     alt="User Image">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">{{ $user->first_name }} {{ $user->last_name }}</h5>
                    <p class="card-text mb-1"><b>Email:</b> {{ $user->email }}</p>
                    <p class="card-text mb-1"><b>Mobile No.:</b> {{ $user->mobile_number }}</p>
                    <p class="card-text mb-1"><b>Birth Of Date:</b> {{ $user->bod }}</p>
                    <div class="mt-auto">
                        @if($user->status == '1')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                        <div class="card-footer text-muted mt-2">
                            <small>Last updated {{ $user->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="row mt-2">
        <div class="col-md-12 text-center">
            {{$users->links()}}
        </div>
    </div>
@else
    <div class="col-12">
        <div class="card">
            <div class="card-header text-uppercase text-center">
                <b>User Card</b>
            </div>
            <div class="card-body">
                <div class="col-12 text-center"><i class="fa  fa-exclamation-triangle"></i> &nbsp;User List not
                    Found
                </div>
            </div>
        </div>
    </div>
@endif
