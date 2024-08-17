@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>My Cash Task</h1>
            </div>
            <div class="col-sm-6">
                <!-- Additional header content (if needed) -->
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Department</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('department.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="POST" id="departmentForm" name="departmentForm">
                @csrf
                @method('PUT') <!-- Indicate that this is an update request -->
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', $department->name) }}">
                                    <p></p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Manager -->
                                <div class="mb-3">
                                    <label for="manager_id">Manager</label>
                                    <select name="manager_id" id="manager_id" class="form-control">
                                        <option value="">None</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ $employee->id == $department->manager_id ? 'selected' : '' }}>
                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('department.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</section>
<!-- /.content -->

@endsection

@section('customsJs')
<script>
    $("#departmentForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $('button[type=submit]').prop('disabled', true);
        $.ajax({
            type: "POST",
            url : '{{ route("department.update") }}',
            data : element.serializeArray(),
            datatype: 'json',
            success : function(response){
                $('button[type=submit]').prop('disabled', false);
                var errors = response['errors'];
                if (response['status'] == true) {
                    window.location.href = '{{ route("department.index") }}';
                } else {
                    if (errors['name']) {
                        $("#name").addClass('is-invalid')
                            .siblings('p').addClass('invalid-feedback')
                            .html(errors['name']);
                    } else {
                        $("#name").removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback')
                            .html(errors['']); 
                    }
                }
            },
            error: function(jqxHR, exception){
                console.log("something went wrong");
            }
        });
    });
    
    // Code for generating slug automatically (if needed)
    $("#name").change(function(event) {
        event.preventDefault();
        var element = $(this);
        var title = element.val(); 
        $('button[type=submit]').prop('disabled', true);
        // Add slug generation logic here if needed
    });
</script>
@endsection
