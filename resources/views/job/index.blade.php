<x-layout>
    @forelse($jobs as $job)
    <p>{{$job->title}}</p>
    @empty
    <p>No jobs available</p>
    @endforelse

</x-layout>