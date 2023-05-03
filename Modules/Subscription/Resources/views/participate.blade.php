@include('subscription::participate_filter')
@section('child-script')
    <script>
        $('#participate-table').DataTable( {
            language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "desc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-4 col-sm-12'l>><'row'<'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            searching   : false,
            serverSide: true,
            ajax: {
                url: '{{url('subscription/detail/'.$subscription['id_subscription'].'?ajax=true')}}',
                type: 'GET',
                data : {
                    "id_subscription": $('input[name=id_subscription]').val(),
                }
            }
        } )
    </script>
    @yield('participate-script')
@endsection
@section('participate')
<div class="portlet-body form">
	@yield('filter')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Participant</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table id="participate-table" class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                <thead>
                    <tr>
                        <th> Subscription Receipt </th>
                        <th> User </th>
                        <th> Bought At </th>
                        <th> Expired At </th>
                        <th> Payment Status </th>
                        <th> Price </th>
                        <th> Kuota | Used | Available </th>
                        <th> History </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection