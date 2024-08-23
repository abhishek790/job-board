<x-layout>
    <x-breadcrumbs :links="['My Jobs'=>'#']" class="mb-4"/>
    <div class="mb-8 text-right">
        <x-link-button href="{{route('my-jobs.create')}}">Add New</x-link-button>
    </div>
    
</x-layout>