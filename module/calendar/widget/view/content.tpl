{use class="talma\widgets\FullCalendar"}


<div class="row">
    <div class="col-md-5">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">KALENDARZ</h3>

                <div class="box-tools pull-right">
                    <div class="pull-right box-tools">
                        <!-- button with a dropdown -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i></button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Add new event</a></li>
                                <li><a href="#">Clear events</a></li>
                                <li class="divider"></li>
                                <li><a href="#">View calendar</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                {FullCalendar::widget([
                'googleCalendar' => true,
                'loading' => 'Ładowanie...',
                'config' => [
                'events' => '/calendar/events'
                ]
                ])}
                <!-- /.row -->
            </div>
            <!-- ./box-body -->

        </div>
        <!-- /.box -->
    </div>
</div>