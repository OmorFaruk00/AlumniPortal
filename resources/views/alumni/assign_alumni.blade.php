@extends('layouts.master')

@section('content')
    <div class="mt-2">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 ">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Reg Code</th>
                                <th>Department</th>
                                <th>Batch</th>
                                <th>Passing Year</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>LinkedIn</th>
                                <th>Facebook</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnis as $index => $data)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $data['name'] }}</td>
                                    <td>{{ $data['regcode'] }}</td>
                                    <td>{{ $data['department'] }}</td>
                                    <td>{{ $data['batch'] }}</td>
                                    <td>{{ $data['passing_year'] }}</td>
                                    <td>{{ $data['PHONE_NO'] }}</td>
                                    <td class="text-center">
                                        <img src="{{ $data['image_url']  }}" alt="Photo"
                                            class="rounded-circle border" width="50" height="50">
                                    </td>
                                    <td class="text-center">
                                        @if (!empty($data['LinkedIn_Link']))
                                            <a href="{{ $data['LinkedIn_Link'] }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-linkedin"></i> View
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!empty($data['Facebook_Link']))
                                            <a href="{{ $data['Facebook_Link'] }}" target="_blank"
                                                class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-facebook"></i> View
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('alumni.show', $data['id']) }}" class="btn btn-info">Create</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-center text-bold small">
                Showing {{ count($alumnis) }} Alumni
            </div>
        </div>
    </div>
@endsection
