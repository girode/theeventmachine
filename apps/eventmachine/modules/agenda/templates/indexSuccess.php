<?php use_stylesheet('fullcalendar.min.css') ?>
<?php use_javascript('fullcalendar.min.js') ?>


<div class="row">
    <div class="col-md-9">
        <div id="calendar"></div>
    </div>
  <div class="col-md-3">
      <div id="eventTicker">
        <div>Event 1</div>
        <div>Event 2</div>
        <div>Event 3</div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        // page is now ready, initialize the calendar...

        $('#calendar').fullCalendar({
            // put your options and callbacks here
        })

    });
</script>