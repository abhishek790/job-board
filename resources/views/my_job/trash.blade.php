<x-layout>
    <x-breadcrumbs :links="['My Jobs'=>route('my-jobs.index'),'Job Trash'=>'#']" class="mb-4"/>
    
    @forelse ($jobs as $job)
       <x-job-card :job="$job">
            <div class="text-xs text-slate-500">
                <div class="flex space-x-2">
                    <form action="{{route('my-jobs.restore',$job)}}" method="POST">
                        @csrf
                        
                        <x-button>Restore Job</x-button>
                    </form>
                    <form action="{{route('my_job.forceDelete',$job)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button>Delete Job Permanently</x-button>
                    </form>
                </div>
            </div>
        </x-job-card> 
    @empty
        <div class="rounded-md border border-dashed border-slate-300 p-8">
            <div class="text-center font-medium">
                No jobs in trash
            </div>
        </div>
    @endforelse
</x-layout>