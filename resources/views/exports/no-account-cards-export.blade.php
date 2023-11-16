<table align="left">
    <thead>
        <tr style="background-color: #006100; color: white" >
          
            <th style="background-color: #006100; color: white; ">ID</th>
            <th style="background-color: #006100; color: white" >Account ID</th>
            <th style="background-color: #006100; color: white; ">ID Number</th>
            <th style="background-color: #006100; color: white; ">Valid From</th>
            <th style="background-color: #006100; color: white; ">Valid Until</th>
            <th style="background-color: #006100; color: white; ">Status</th>
      
       
            {{-- <th>Course Reference</th>
            <th>Campus Reference</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($collection as $item)
        <tr>
            <td align="left" width="40">{{ $item?->id }}</td>
            <td align="left" width="40">{{ $item?->account_id}}</td>
            <td align="left" width="40">{{ $item?->id_number}}</td>
            <td align="left" width="40">{{ $item->valid_from ? \Carbon\Carbon::parse($item->valid_from)->format('m/d/Y') : '' }}</td>
            <td align="left" width="40">{{ $item->valid_until ? \Carbon\Carbon::parse($item->valid_until)->format('m/d/Y') : '' }}</td>
            <td align="left" width="40">{{ $item?->status}}</td>
        </tr>
        @endforeach
    </tbody>
</table>