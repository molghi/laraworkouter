<div class="max-w-5xl mx-auto grid grid-cols-3 gap-4">
    @if (!empty(session('finished_workouts')) && count(session('finished_workouts')) > 0)
        <div class="text-center italic col-span-full">Items to show: {{ count(session('finished_workouts')) }}</div>
    @else
        <div class="text-center italic col-span-full">Workouts you start will be displayed here...</div>
    @endif
</div>