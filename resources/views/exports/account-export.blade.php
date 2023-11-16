<table align="left">
    <thead>
        <tr style="background-color: #006100; color: white" >
            <th style="background-color: #006100; color: white; ">ID</th>
            <th style="background-color: #006100; color: white" >First Name</th>
            <th style="background-color: #006100; color: white; ">Last Name</th>
            <th style="background-color: #006100; color: white; ">Middle Name</th>
            <th style="background-color: #006100; color: white; ">Sex</th>
            <th style="background-color: #006100; color: white; ">Birth Date</th>
            <th style="background-color: #006100; color: white; ">Address</th>
            <th style="background-color: #006100; color: white; ">Contact Number</th>
            <th style="background-color: #006100; color: white; ">Account Type</th>
       
            {{-- <th>Course Reference</th>
            <th>Campus Reference</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($collection as $item)
        <tr>
            <td align="left" width="40">{{ $item?->id  ?? ''}}</td>
            <td align="left" width="40">{{ $item?->first_name?? '' }}</td>
            <td align="left" width="40">{{ $item?->last_name?? '' }}</td>
            <td align="left" width="40">{{ $item?->middle_name?? '' }}</td>
            <td align="left" width="40">{{ $item?->sex?? '' }}</td>
            <td align="left" width="40">
                
             {{-- {{ $item?->birth_date??'' }} --}}

             {{ $item->birth_date ? \Carbon\Carbon::parse($item->birth_date)->format('m/d/Y') : '' }}
             </td>
            <td align="left" width="100">{{ $item?->address?? '' }}</td>
            <td align="left" width="40">{{ $item?->contact_number??'' }}</td>
            <td align="left" width="40">{{ $item?->account_type??'' }}</td>
          
          
            


        </tr>
        @endforeach
    </tbody>
</table>