@extends('layouts.admin')
@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">
                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                {{ trans('global.systemCalendar') }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans('global.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('global.systemCalendar') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Calendar Card --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' />
            <style>
                #calendar .fc-toolbar h2 { font-size: 1.1rem; font-weight: 700; }
                #calendar .fc-button { background: #4e73df; border-color: #4e73df; border-radius: 6px; font-size: 0.8rem; padding: 4px 10px; }
                #calendar .fc-button:hover { background: #2e59d9; border-color: #2653d4; }
                #calendar .fc-today { background: #eef2ff !important; }
                #calendar .fc-event { border-radius: 4px; font-size: 0.78rem; padding: 2px 5px; border: none; }
                #calendar .fc-day-header { background: #f8f9fc; font-weight: 600; font-size: 0.82rem; color: #555; padding: 8px 0; }
                #calendar .fc-head { border-bottom: 2px solid #e3e6f0; }
            </style>
            <div id='calendar'></div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
    $(document).ready(function () {
        var events = {!! json_encode($events) !!};
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: events,
            editable: false,
            eventLimit: true,
            themeSystem: 'standard',
            eventRender: function(event, element) {
                if (!element.css('background-color') || element.css('background-color') === 'rgba(0, 0, 0, 0)') {
                    element.css('background-color', '#4e73df');
                    element.css('border-color', '#4e73df');
                }
            }
        });
    });
</script>
@stop
