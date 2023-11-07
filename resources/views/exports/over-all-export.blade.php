<table>
    <thead>
        <tr style="background-color: #406e40; color: white" >
            <th style="background-color: #406e40; color: white; ">Account</th>
            <th style="background-color: #406e40; color: white; ">  Card ID</th>
            <th style="background-color: #406e40; color: white; "> Account Type</th>
            <th style="background-color: #406e40; color: white; ">Time In</th>
            <th style="background-color: #406e40; color: white; ">Time Out</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($collections as $item)
        <tr>
            <td align="left" width="40">
                @if (!empty($item->card))
                @if (!empty($item->card->account))
                    {{ $item->card->account->last_name . ', ' ?? '' }}
                    {{ $item->card->account->first_name }} {{ $item->card->account->middle_name }}
                @else
                    No Account Found
                @endif
            @else
                No Card Found
            @endif
            </td>
            <td align="left" width="40">
                @if (!empty($item->card))
                {{ $item->card->id_number }}
            @else
                No Card Found
            @endif
            </td>
            <td align="left" width="40">
                @if (!empty($item->card))
                @if (!empty($item->card->account))


                    {{ $item->card->account->account_type ?? '' }}
                  
                @else
                    No Account Found
                @endif
            @else
                No Card Found
            @endif
            </td>
            <td align="left" width="40">
             
                @if ($item->entry)
                {{ $item->created_at->format('l-F d, Y h:i:s A') }}
            @else
                None
            @endif
            
            </td>
            <td align="left" width="40">
                @if ($item->entry == true && $item->exit == true)
                {{ $item->updated_at->format('l-F d, Y h:i:s A') }}
            @else
            -- No Exit -- 
            @endif
            </td>
            
        </tr>
        @endforeach
        <tr>
            <td style="background-color: #e2ece2; color: black;">
                @if (count($collections) > 0)
                    Total
                @endif
            </td>
            <td colspan="4" style="background-color: #e2ece2; color: black;">
                @if (count($collections) > 0)
                    {{ count($collections) }}
                @endif
            </td>
        </tr>
    </tbody>
</table>