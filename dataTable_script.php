<script type="text/javascript">
    $(document).ready(function() {

        var table =
            $('#process_data_table').DataTable({


                processing: false,

                serverSide: true,

                paging: true,

                pageLength: 10,

                lengthChange: true,

                searching: true,

                ordering: true,

                info: true,

                autoWidth: false,

                dom: 'l<"#date-filter"><"#action-filter"><"#zone-filter"><"#status-filter">frtip',

                ajax: {

                    url: 'resident_filter_data',

                    type: 'POST',

                    data: function(d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [

                    {

                        data: 'id',

                        name: 'id',

                        searchable: false,

                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }

                    },
                    {

                        data: 'resident_name',

                        name: 'resident_name',

                        searchable: true

                    },
                    {

                        data: 'zone',

                        name: 'zone',

                        searchable: true,

                    },
                    {

                        data: 'resident_category',

                        name: 'resident_category',

                        searchable: true

                    },
                    {

                        data: 'manager_cell',

                        name: 'manager_cell',

                        searchable: true

                    },
                    {

                        data: 'sms_rate',

                        name: 'sms_rate',

                        searchable: true,
                        render: function(data, type, row) {

                            return '<div class="badge badge-pill badge-info">' + row.sms_rate + ' BDT</div>'
                        }

                    },
                    {

                        data: 'monthly_rate',

                        name: 'monthly_rate',

                        searchable: true,

                        render: function(data, type, row) {

                            return '<div class="badge badge-pill badge-primary">' + row.monthly_rate + ' BDT</div>'
                        }

                    },
                    {

                        data: 'status',

                        name: 'status',

                        searchable: true,

                        render: function(data, type, row) {

                            if (row.status == 0) {
                                return '<input type="text" value="" hidden><div class="badge badge-pill badge-danger">Inactive</div>'

                            } else {
                                return '<div class="badge badge-pill badge-success">Active</div>'
                            }
                        }

                    },
                    {

                        data: 'created_at',

                        name: 'created_at',

                        searchable: false,

                        render: function(data, type, row) {

                            return moment(row.created_at).format("MMMM Do YYYY");
                        }

                    },
                    {

                        data: 'id',

                        id: 'id',

                        status: 'status',

                        searchable: false,

                        render: function(data, type, row) {

                            if (row.status == 1) {

                                return "<a href='update-resident-status/" + row.id + "/" + row.status + "' class='btn-hover-shine btn btn-shadow btn-alternate btn-sm'>Inactive</a> | <a href='view-resident/" + row.id + "' class='btn-hover-shine btn-hover-shinebtn-shadow btn btn-warning btn-sm'>View</a> | <a href='update-resident-status/" + row.id + "/" + row.id + "' class='btn-hover-shine btn btn-shadow btn-danger btn-sm'>Delete</a>";

                            } else {

                                return "<a href='update-resident-status/" + row.id + "/" + row.status + "' class='btn-hover-shine btn-shadow btn btn-success btn-sm'>Active</a> | <a href='view-resident/" + row.id + "' class='btn-hover-shine btn-hover-shinebtn-shadow btn btn-warning btn-sm'>View</a> | <a href='update-resident-status/" + row.id + "/" + row.id + "' class='btn-hover-shine btn btn-shadow btn-danger btn-sm'>Delete</a>";

                            }

                            /* return "<a href='view-resident/" + row.id + "' class='btn-hover-shine btn-hover-shinebtn-shadow btn btn-warning btn-sm'>View</a> | <a href='update-resident-status/" + row.id + "/" + row.id + "' class='btn-hover-shine btn btn-shadow btn-danger btn-sm'>Delete</a>";
                             */
                        }

                    },

                ]

            });


        $("table").wrapAll("<div style='overflow-x:auto;width:100%' />");

        $('.dataTables_wrapper').addClass('row');

        // $('.dataTables_processing').addClass('m-loader m-loader--brand');

        $('#process_data_table_length').addClass('col-lg-2 col-md-2 col-sm-2');

        $('#process_data_table_length select').addClass('custom-select custom-select-sm form-control form-control-sm');



        $('#date-filter').addClass('col-lg-4 col-md-4 col-sm-4 adjust');

        $('#action-filter').addClass('col-lg-2 col-md-2 col-sm-2');
        $('#zone-filter').addClass('col-lg-1 col-md-2 col-sm-2');
        $('#status-filter').addClass('col-lg-1 col-md-1 col-sm-2');

        $('#process_data_table_filter').addClass('col-lg-2 col-md-2 col-sm-2');



        $('#process_data_table_filter input').addClass('form-control form-control-sm');

        var category_filter_html = '<select class="form-control-sm form-control" id="resident_zone">' +

            '<option value="">Zone</option>' +
            '<option value="A">A</option>' +
            '<option value="B">B</option>' +
            '<option value="C">C</option>' +
            '<option value="D">D</option>' +
            '<option value="E">E</option>' +

            '</select>';

        $('#zone-filter').append(category_filter_html);

        var status_filter_html = '<select class="form-control-sm form-control" id="resident_status">' +

            '<option value="">Status</option>' +
            '<option value="1">Active</option>' +
            '<option value="0">Inactive</option>' +

            '</select>';

        $('#status-filter').css("padding", "0");
        $('#status-filter').append(status_filter_html);


        var action_filter_html = '<select class="form-control-sm form-control" id="resident_category" data-select2-id="2" tabindex="-1" aria-hidden="true">' +

            '<option value="">Select Category</option>' +
            '<option value="Hotel">Hotel</option>' +
            '<option value="Motel">Motel</option>' +
            '<option value="Resort">Resort</option>' +
            '<option value="Guest House">Guest House</option>' +
            '<option value="Cottage">Cottage</option>' +
            '<option value="Others">Others</option>' +

            '</select>';

        $('#action-filter').append(action_filter_html);


        $('#resident_zone').on('change', function() {

            var resident_zone = $(this).val();
            if (resident_zone != "") {
                table.columns(2).search(resident_zone).draw();
            }
        })

        $('#resident_category').on('change', function() {

            var resident_category = $(this).val();
            if (resident_category != "") {
                table.columns(3).search(resident_category).draw();
            }
        });

        $('#resident_status').on('change', function() {

            var resident_status = $(this).val();
            if (resident_status != "") {
                table.columns(7).search(resident_status).draw();
            }
        });

        var date_picker_html = '<div id="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;"> <i class="fa fa-calendar"> </i>&nbsp; <span> </span> <i class="fa fa-caret-down"></i></div>';

        $('#date-filter').append(date_picker_html);

        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {

                $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                var range = start.format("YYYY-MM-DD") + "~" + end.format("YYYY-MM-DD");

                table.columns(7).search(range).draw();

                //alert(range);
            }

            $('#date_range').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        });

    });
</script>

<?php 

public function resident_filter_data(Request $request)
{

    $date = $request->get('columns')[8]['search']['value'];

    if ($date != '') {

        list($start_date, $end_date) = explode('~', preg_replace('/\s+/', '', $date));

        $start_date = date_validate($start_date);
        $end_date = date_validate($end_date);
    } else {

        $time = strtotime(date('Y-m-d') . '-30 days');
        $start_date = date_validate(date('Y-m-d', $time));
        $end_date = date_validate(date('Y-m-d'));
    }

    $dataSet = DB::table("users")

        ->where('user_type', 'User')
        ->where('status', '<=', 1)
        ->whereBetween('created_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"])
        ->orderBy('created_at', 'DESC');

    return Datatables::of($dataSet)->make(true);
}

?>