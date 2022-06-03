<!-- <script>
    $(function() {
        $('#start').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: "dateToday",
            onSelect: function(datetext) {
                var d = new Date(); // for now

                var h = d.getHours();
                h = (h < 10) ? ("0" + h) : h;

                var m = d.getMinutes();
                m = (m < 10) ? ("0" + m) : m;

                var s = d.getSeconds();
                s = (s < 10) ? ("0" + s) : s;

                datetext = datetext + " " + h + ":" + m + ":" + s;

                $('#start').val(datetext);
            }
        });
        $('#end').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: "dateToday",
            onSelect: function(datetext) {
                var d = new Date(); // for now

                var h = d.getHours();
                h = (h < 10) ? ("0" + h) : h;

                var m = d.getMinutes();
                m = (m < 10) ? ("0" + m) : m;

                var s = d.getSeconds();
                s = (s < 10) ? ("0" + s) : s;

                datetext = datetext + " " + h + ":" + m + ":" + s;

                $('#end').val(datetext);
            }
        });
    });
</script> -->
<script>
    $(document).ready(function() {

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: true,
            select: function(start, end) {

                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                console.log(event);
                element.bind('click', function() {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #color').val(event.color);
                    $('#ModalEdit #start').val(event.start);
                    $('#ModalEdit #end').val(event.end);
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function(event, delta, revertFunc) { // si changement de position

                edit(event);

            },
            eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                edit(event);

            },
            events: [
                <?php foreach ($events as $event) :

                    $start = explode(" ", $event['start_event']);
                    $end = explode(" ", $event['end_event']);
                    if ($start[1] == '00:00:00') {
                        $start = $start[0];
                    } else {
                        $start = $event['start_event'];
                    }
                    if ($end[1] == '00:00:00') {
                        $end = $end[0];
                    } else {
                        $end = $event['end_event'];
                    }
                ?> {
                        id: '<?php echo $event['id_event']; ?>',
                        title: '<?php echo $event['title']; ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $event['color']; ?>',
                    },
                <?php endforeach; ?>
            ]
        });

        function edit(event) {
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if (event.end) {
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            } else {
                end = start;
            }

            // var start = $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
            // var end = $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            // var start = $.fullCalendar.format(start, "Y-MM-DD HH:mm:ss");
            // var end = $.fullCalendar.format(end, "Y-MM-DD HH:mm:ss");
            var title = event.title;

            var id = event.id;

            $.ajax({
                url: "<?= base_url() ?>pengurus/list_event/update",

                type: "POST",
                data: {
                    title: title,
                    start: start,
                    end: end,
                    id: id
                },
                success: function() {
                    calendar.fullCalendar('refetchEvents');
                    alert('Event Update');
                }
            });
        }

    });
</script>