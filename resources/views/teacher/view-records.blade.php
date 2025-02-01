@section('title', 'View Attendance')
<x-teacher-layout>
    <div>
        <div class="flex space-x-3 items-end">
            <x-button label="Back" sm slate icon="arrow-left" href="{{ route('teacher.attendance') }}" />
            <h1 class="text-2xl font-semibold uppercase text-main">Attendance Records</h1>
        </div>
        <div class="mt-10">
            <livewire:teacher.view-record />
            <script>
                function printOut(data) {
                    var mywindow = window.open('', '', 'height=1000,width=1000');
                    mywindow.document.head.innerHTML =
                        '<title></title><link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />';
                    mywindow.document.body.innerHTML = '<div>' + data +
                        '</div><script src="{{ Vite::asset('resources/js/app.js') }}"/>';

                    mywindow.document.close();
                    mywindow.focus(); // necessary for IE >= 10

                    setTimeout(() => {
                        mywindow.print();
                        mywindow.onafterprint = function() {
                            mywindow.close();
                        };
                    }, 1000);
                }
            </script>
        </div>

</x-teacher-layout>
