<?php
// +===================================+
// | Date Validate HELPER.php  |
// +===================================+
if (!function_exists('datetime_validate')) {

    function datetime_validate($date, $format = ('Y-m-d h:i:s'))

    {

        return date($format, strtotime($date));
    }
}

if (!function_exists('date_validate')) {

    function date_validate($date, $format = ('Y-m-d'))

    {

        return date($format, strtotime($date));
    }
}

if (!function_exists('datetime_output')) {

    function datetime_output($date, $format = ('"jS F Y g:i A"'))

    {

        return date($format, strtotime($date));
    }
}

if (!function_exists('javascript_dateformate')) {

    function javascript_dateformate($date, $format = ('m/d/Y h:i:s A'))

    {

        return date($format, strtotime($date));
    }
}

// +===================================+
// | First & Last day of previous month |
// +===================================+

$last_start = date('Y-m-d', strtotime("first day of previous month"));
$last_end = date('Y-m-d', strtotime("last day of previous month"));

// +===================================+
// | Time or Date Interval / Difference |
// +===================================+

$total_duration = 26;

$time = strtotime(-$total_duration . 'months');

$interval = date_diff(date_create(date("Y-m-d")), date_create(date("Y-m-d", $time)));

if ($interval->y != 0 && $interval->m != 0) {

    echo $interval->y . ' years ' . $interval->m . ' months';
} else if ($interval->y != 0 && $interval->m == 0) {

    echo $interval->y . ' years';
} else {
    echo $interval->m . ' months';
}


// +===================================+
// | DataTable Date Difference |
// +===================================+

if ($date != '') {

    list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

    $start_date = date_validate($start_date);
    $end_date = date_validate($end_date);
} else {

    $time = strtotime(date('Y-m-d') . '-30 days');
    $start_date = date_validate(date('Y-m-d', $time));
    $end_date = date_validate(date('Y-m-d'));
}

// +===================================+
// | 10 minutes before current time |
// +===================================+

$time = strtotime(date('Y-m-d H:i:s') . '-10 minutes');
$start_date = date('Y-m-d H:i:s', $time);
$end_date = date('Y-m-d H:i:s');

?>

<script>
    // +===================================+
    // | DataTable DateTime Format |
    // +===================================+

    render: function(data, type, row) {

        return moment(row.check_in).format("MMMM Do YYYY, h:mm:ss A");
    }

    // +===================================+
    // | DataTable Time Difference |
    // +===================================+

    render: function(data, type, row) {

        var compareTo = moment(row.created_at).unix(Number);

        var CurrentDate = moment().add(-10, 'minutes').unix(Number);

        var isAfter = moment(CurrentDate).isAfter(compareTo);


        if (CurrentDate > compareTo || row.expire == 1) {
            return '<div class="badge badge-pill badge-danger">Expired</div>'

        } else {
            return '<div class="badge badge-pill badge-success">Active</div>'
        }
    }
</script>