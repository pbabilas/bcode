{use class="talma\widgets\FullCalendar"}


{FullCalendar::widget([
    'googleCalendar' => true,
    'loading' => 'Ładowanie...',
    'config' => [
    'events' => '/calendar/events'
    ]
])}
