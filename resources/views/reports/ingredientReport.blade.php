@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    
    <div id="UseReport" class="col" style="background-color:white" class="w-75 float-right p-5">
        <h3 class="display-2">Menu Report</h3>
        <hr style="height: 2px; background-color:orange">
        <div class="p-5">

            <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%" id="usage">
                <thead>
                    <tr>
                        <th class="th-sm">Date
                        </th>
                        <th class="th-sm">Item
                        </th>
                        <th class="th-sm">Times Purchased
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($byMonths as $month)
                        <tr class="data">
                            <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $month->pickup_date)->format('M Y') }}
                            </td>
                            <td><a href="editMenuItem/{{ $month->menu_id }}">{{ $month->name }}</a></td>
                            <td>{{ $month->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#usage').DataTable({
                "pageLength": 25,
                "drawCallback": function(settings) {
                    var total = 0.00;
                    $('#usage > tbody  > tr').each(function(index, tr) {
                        total += parseFloat(tr.childNodes[9].innerHTML)
                        console.log(total);
                    });
                    $('#total').text(total.toFixed(2));
                }
            });
        });
    </script>
@endsection
