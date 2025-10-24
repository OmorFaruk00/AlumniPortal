@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4>Users List</h4>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('user.create') }}" class="btn btn-success">Create User</a>
                    @endif
                @endauth
            </div>
        </div>
        <div class="card-body">
             <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 ">
                        <thead class="table-dark text-center">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->designation }}</td>
                                <td>
                                    @if ($user->image)
                                        <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" height="80"
                                            width="80" class="">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>

                                <td>
                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">Edit</a>
                                        @endif
                                    @endauth
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>
@endsection
