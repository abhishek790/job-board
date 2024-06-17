<x-layout>
    @foreach($jobs as $job)
        <x-job-card class="mb-4">
            <div>
                <x-link-button :href="route('jobs.show',['job'=>$job->id])">
                    Show
                </x-link-button>
            </div>
        </x-job-card>
    @endforeach
`
</x-layout>