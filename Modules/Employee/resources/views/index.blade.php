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

            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create employee</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('employee.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->

    <div class="container-fluid">
        <form action="" method="post" id="employeeForm" name="employeeForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="name" class="form-control" placeholder="First Name">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="slug" class="form-control" placeholder="Last Name">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="image_id" id="image_id" value="">
                        <label for="image">Image</label>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                Drop files here or click to upload
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Salary -->
                        <div class="mb-3">
                            <label for="salary">Salary</label>
                            <input type="number" name="salary" id="salary" class="form-control" placeholder="Salary" step="0.01" required>
                            <p class="error"></p>
                        </div>
                    </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Department -->
                                <div class="mb-3">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="form-control" required>
                                        <!-- Populate options dynamically -->
                                        {{-- @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
    
                            <div class="col-md-4">
                                <!-- Manager -->
                                <div class="mb-3">
                                    <label for="manager_id">Manager</label>
                                    <select name="manager_id" id="manager_id" class="form-control">
                                        <option value="">None</option>
                                        <!-- Populate options dynamically -->
                                        {{-- @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_id">User</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <!-- Populate options dynamically -->
                                    {{-- @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach --}}
                                </select>
                                <p class="error"></p>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>

                <a href="{{ route('employee.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>

            </div>
        </form>
    </div>

    <!-- /.card -->
</section>
<!-- /.content -->

@endsection


@section('customsJs')
<script>
       $("#productForm").submit(function(event) {
        event.preventDefault();
        var element = $(this);
        $('#createSubCategoryBtn').prop('disabled', true);
        $.ajax({
            url: '{{ route('employee.store') }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'formArray',
            success: function(response) {
                if (response['status'] == true) {
                    $(".error").removeClass("invalid-feedback").html('');
                    $("input[type='text'], select, input[type='number']").removeClass("is-invalid");
                    window.location.href = "{{ route('employee.index') }}";
                } else {
                    var errors = response['errors'];
                    $("input[type='text'], select, input[type='number']").removeClass("is-invalid");
                    $(".error").removeClass("invalid-feedback").html('');
                    if (errors) {
                        $.each(errors, function(key, error) {
                            $(`#${key}`).addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(error);
                        });
                    }
                }
            },
            error: function(jqXHR, exception) {
                console.log("something went wrong");
            }
        });
    });

            


            

             Dropzone.autoDiscover = false;
              /**
     * Setup dropzone
     */
    const dropzone = $('#image').dropzone({
        init: function() 
        {
            // myDropzone = this;

            // when file is dragged in
            this.on('addedfile', function(file) { 
                if(this.files.length>1){
                        // this.removeFile(this.files[0]);
                }
            });
        },
       
        url: "{{ route('temp-image.create') }}",
        addRemoveLinks: true,
        
        parallelUploads: 1,
        maxFiles: 1,
        paramName: 'image',
        acceptedFiles: '.jpeg, .jpg, .png, .gif',
        timeout: 0,
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    
        success: function(file, response) 
        {
        $("#image_id").val(response.image_id)
        }
    });

</script>

@endsection