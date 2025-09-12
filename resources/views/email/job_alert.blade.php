<!-- filepath: c:\xampp\htdocs\job_seek_pr\resources\views\emails\job_alert.blade.php -->

<h2>New Job Matching Your Preferences!</h2>
<p><strong>{{ $job->title }}</strong></p>
<p>Company: {{ $job->company_name }}</p>
<p>Location: {{ $job->location }}</p>
<p><a href="{{ url('/jobs/detail' . $job->id) }}">View Job</a></p>