@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Departments</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('department.create') }}" class="btn btn-primary">New department</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <p>@include('message')</p>
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route('department.index') }}'" class="btn btn-default btn-sm">Reset</button>
                    </div>
                    <div class="card-tools">
                        <div class="input-group" style="width: 250px;">
                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>Manager</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($departments->isNotEmpty())
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->manager ? $department->manager->first_name . ' ' . $department->manager->last_name : 'No Manager' }}</td>
                                    <td>
                                        <a href="{{ route('department.edit', $department->id) }}" class="text-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="deletedepartment({{ $department->id }})" class="text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Records Not Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection


@section('customsJs')
<script>
    function deleteDepartment(department_id){
        var url = "{{ route('department.destroy', 'ID') }}";
        url = url.replace('ID', department_id);
        $.ajax({
            url: url,
            type: 'delete',
            data: {}, // You can include data if needed
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                if (response.status == true){
                    window.location.href = '{{ route("department.index") }}';
                }
            },
            error: function(jqXHR, exception){
                console.log("Something went wrong");
            }
        });
    }
</script>
@endsection
