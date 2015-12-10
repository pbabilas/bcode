{use class="talma\widgets\FullCalendar"}

<div class="row">
    <div class="col-md-4">
        <div class="modal-content col-md-12">
            <div class="modal-header"><div class="bootstrap-dialog-header">
                    Kalendarz
                </div></div>
            {FullCalendar::widget([
            'googleCalendar' => true,
            'loading' => 'Ładowanie...',
            'config' => [
            'events' => '/calendar/events'
            ]
            ])}
        </div>
    </div>


    <div class="modal-content col-md-2">
        <div class="col-md-12">
            <div class="modal-header"><div class="bootstrap-dialog-header">
                    Notatka a
                </div></div>
            test testowy test test test
            test testowy test test test
            test testowy test test testtest testowy test test testtest testowy test test test
        </div>
    </div>
</div>