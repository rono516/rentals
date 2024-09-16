<div class="table-responsive">
    <table class="table table-borderless table-sm">
        <tr>
            <td class="text-end">ID Number:</td>
            <td><b>{{ $house->tenant->id_number }}</b></td>
        </tr>
        <tr>
            <td class="text-end">Name:</td>
            <td><b>{{ $house->tenant->user->name }}</b></td>
        </tr>
        <tr>
            <td class="text-end">Phone:</td>
            <td><b>{{ $house->tenant->phone }}</b></td>
        </tr>
        <tr>
            <td class="text-end">Email:</td>
            <td><b>{{ $house->tenant->user->email }}</b></td>
        </tr>
    </table>
</div>
