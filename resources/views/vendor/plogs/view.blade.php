<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs</title>

    <link rel="shortcut icon" href="/logs.ico">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">

    <style>
        body {
            padding: 10px;
        }

        .stack {
            font-size: 0.85em;
        }

        .date {
            min-width: 140px;
        }

        .date, .level, .context {
            text-align: center;
            font-size: 90% !important;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }

        thead tr {
            background-image: radial-gradient(#ffe773, #d9bd36);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 table-container">

            <table id="table-log" class="table table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Message</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Type</th>
                    <th>Date</th>
                    <th>&nbsp;</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.toggleDetails', function () {
            $('#' + $(this).data('display')).toggle();
        });

        var table = $('#table-log').DataTable({
            "serverSide": true,
            "processing": true,
            "responsive": true,
            "autoWidth": false,
            "bSortClasses": false,
            "pageLength": {{ config('plogs.entries_per_page') }},
            "order": [1, 'desc'],
            "ajax": {
                "url": "{{ route('__plogstable__') }}",
                "dataType": "json",
                "type": "GET",
                "data": {_token: "{{csrf_token()}}"}
            },
            "columns": [
                {data: 'level'},
                {data: 'created_at'},
                {data: 'message'}
            ],
            "columnDefs": [
                {"width": "1%", "targets": 0},
                {"width": "13%", "targets": 1}
            ],
            "initComplete": function (settings, json) {
                $("#table-log tfoot th:not(:last)").each(function (i) {
                    var select = $('<select style="width: 100%;"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {
                            table.column(i)
                                .search($(this).val(), true, false)
                                .draw();
                        });

                    if (i == 0) {
                        @foreach($levels as $level)
                        select.append('<option value="{{$level}}">{{ucfirst($level)}}</option>');
                        @endforeach
                    }
                    else {
                        @foreach($dates as $date)
                        select.append('<option value="{{$date}}">{{ucfirst($date)}}</option>');
                        @endforeach
                    }
                });

                // put filters on header
                $('tfoot').css('display', 'table-header-group');
            }
        });

    });
</script>
</body>
</html>
