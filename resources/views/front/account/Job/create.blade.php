@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.layouts.message')

                {{-- Job Details --}}
                <form action="{{ route('account.saveJob') }}" method="post" id="createJobForm">
                    @csrf
                    <div class="card border-0 shadow p-4">
                        <h3>Job Details</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" id="title"  class="form-control" placeholder="Job Title">
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select name="category" id="category"  class="form-control">
                                    <option>Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Job Type *</label>
                                <select name="jobType" id="jobType" class="form-control">
                                    <option value="">Select Job Nature</option>
                                    @foreach ($jobTypes as $jobType)
                                        <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                    @endforeach
                                </select>
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vacancy *</label>
                                <input type="number" name="vacancy" id="vacancy" class="form-control" placeholder="Vacancy">
                                <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Salary *</label>
                                <input type="text" name="salary" id="salary" class="form-control" placeholder="Salary">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location *</label>
                                <input type="text" name="job_location" id="job_location" class="form-control" placeholder="Location">
                                <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Description"></textarea>
                           <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Benefits</label>
                                <textarea name="benefits" class="form-control" rows="3" placeholder="Benefits"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Responsibility</label>
                                <textarea name="responsibility" class="form-control" rows="3" placeholder="Responsibility"></textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="3" placeholder="Qualifications"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">Experience *</label>
                            <select name="experience" class="form-control">
                                <option value="1">1 year</option>
                                <option value="2">2 years</option>
                                <option value="3">3 years</option>
                                <option value="4">4 years</option>
                                <option value="5">5 years</option>
                                <option value="6">6 years</option>
                                <option value="7">7 years</option>
                                <option value="8">8 years</option>
                                <option value="9">9 years</option>
                                <option value="10">10 years</option>
                                <option value="11">10+ years</option>
                            </select>
                            <p></p>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Keywords</label>
                                <textarea name="keywords" class="form-control" rows="1" placeholder="Keywords"></textarea>
                            </div>
                        </div>

                        {{-- Company Details --}}
                        <h3 class="mt-4">Company Details</h3>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Name *</label>
                                <input type="text" id="company_name"  name="company_name" class="form-control" placeholder="Company Name">
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location *</label>
                                <input type="text" name="company_location" class="form-control" placeholder="Company Location">
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">Website *</label>
                            <input type="text" name="website" class="form-control" placeholder="Website URL">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection


@section('customJs')
<script type="text/javascript">
 $("#createJobForm").submit(function(e){
    e.preventDefault();
    
    $.ajax({
        url:'{{route("account.saveJob")}}',
        type:'post',
        dataType:'json',
        data:$("#createJobForm").serializeArray(),
        success:function(response){
            console.log("Success Response:", response);
            if(response.status==true){
                $("#title").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')

                $("#category").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')
                $("#jobType").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')
                $("#vacancy").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')
                $("#location").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')
                $("#description").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')
                $("#company_name").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')
               
                window.location.href = "/account/my-jobs";

            }
            else{
                var errors=response.errors;

                if(errors.title){
                        $("#title").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.title[0])
                    }
                    else{
                        $("#title").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')

                    }
                    if(errors.category){
                        $("#category").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.category[0])
                    }
                    else{
                        $("#category").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                }
                if(errors.jobType){
                        $("#jobType").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.jobType[0])
                    }
                    else{
                        $("#jobType").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                }
                if(errors.vacancy){
                        $("#vacancy").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.vacancy[0])
                    }
                    else{
                        $("#vacancy").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                }
                if(errors.location){
                        $("#location").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.location[0])
                    }
                    else{
                        $("#location").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                }
                if(errors.description){
                        $("#description").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.description[0])
                    }
                    else{
                        $("#description").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                }
                if(errors.company_name){
                        $("#company_name").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.company_name[0])
                    }
                    else{
                        $("#company_name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                }
            }
        }
    });
 });
</script>
@endsection