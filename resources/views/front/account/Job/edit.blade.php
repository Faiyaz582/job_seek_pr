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
                <form action="{{ route('front.account.saveJob') }}" method="post" id="editJobForm" name="editJobForm">
                    @csrf
                    <div class="card border-0 shadow p-4">
                        <h3>Edit Job Details</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Title *</label>
                                <input value="{{$job->title}}" type="text" name="title" id="title"  class="form-control" placeholder="Job Title">
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select name="category" id="category"  class="form-control">
                                    <option>Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option {{($job->category_id==$category->id)?'selected':' '}} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                        <option {{($job->job_type_id==$jobType->id)?'selected':' '}} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                    @endforeach
                                </select>
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vacancy *</label>
                                <input value="{{$job->vacancy}}"type="number" name="vacancy" id="vacancy" class="form-control" placeholder="Vacancy">
                                <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Salary *</label>
                                <input value="{{$job->salary}}" type="text" name="salary" id="salary" class="form-control" placeholder="Salary">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location *</label>
                                <input value="{{$job->location}}" type="text" name="job_location" id="job_location" class="form-control" placeholder="Location">
                                <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Description">{{$job->description}}</textarea>
                           <p></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Benefits</label>
                                <textarea name="benefits" class="form-control" rows="3" placeholder="Benefits">{{$job->benefits}}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Responsibility</label>
                                <textarea name="responsibility" class="form-control" rows="3" placeholder="Responsibility">{{$job->responsibility}}</textarea>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="3" placeholder="Qualifications">{{$job->qualifications}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label class="form-label">Experience *</label>
                            <select name="experience" class="form-control">
                                <option value="1" {{($job->experience==1)?'selected':''}}>1 year</option>
                                <option value="2" {{($job->experience==2)?'selected':''}}>2 years</option>
                                <option value="3" {{($job->experience==3)?'selected':''}}>3 years</option>
                                <option value="4" {{($job->experience==4)?'selected':''}}>4 years</option>
                                <option value="5" {{($job->experience==5)?'selected':''}}>5 years</option>
                                <option value="6" {{($job->experience==6)?'selected':''}}>6 years</option>
                                <option value="7" {{($job->experience==7)?'selected':''}}>7 years</option>
                                <option value="8" {{($job->experience==8)?'selected':''}}>8 years</option>
                                <option value="9" {{($job->experience==9)?'selected':''}}>9 years</option>
                                <option value="10" {{($job->experience==10)?'selected':''}}>10 years</option>
                                <option value="11" {{($job->experience=='10_plus')?'selected':''}}>10+ years</option>
                            </select>
                            <p></p>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Keywords</label>
                                <input value="{{$job->keywords}}" type="text" placeholder="keywords" id="keywords" name="keywords">
                                <!-- <textarea name="keywords" class="form-control" rows="1" placeholder="Keywords"></textarea> -->
                            </div>
                        </div>

                        {{-- Company Details --}}
                        <h3 class="mt-4">Company Details</h3>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Name *</label>
                                <input value="{{$job->company_name}}" type="text" id="company_name"  name="company_name" class="form-control" placeholder="Company Name">
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location *</label>
                                <input value="{{$job->company_location}}" type="text" name="company_location" class="form-control" placeholder="Company Location">
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">Website *</label>
                            <input value="{{$job->company_website}}" type="text" name="website" class="form-control" placeholder="Website URL">
                        </div>

                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update Jobs</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection


@section('customJs')
<script type="text/javascript">
 $("#editJobForm").submit(function(e){
    e.preventDefault();
    $("button[type='submit']").prop('disabled',true); //for disabiling update button after updating
    $.ajax({
        url:'{{route("front.account.updateJob",$job->id)}}',
        type:'post',
        dataType:'json',
        data:$("#editJobForm").serializeArray(),
        success:function(response){
            $("button[type='submit']").prop('disabled',false);
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