<table width="100%" style="" border="0">
    <tr>
        <td width="100%">
           <h1>
            Report - {{ $date->format('d. m. Y h:m:s') }}
           </h1>
        </td>
    </tr>
    <tr>
        <td width="100%">
           <h3> Schemes </h3>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        @foreach($experiment->schemes()->whereIn('prefix', $schemes)->get() as $scheme)
        <th>
            <h1>{{ $scheme->title }}</h1>
        </th>
        @endforeach
    </tr>
    <tr>
        @foreach($experiment->schemes()->whereIn('prefix', $schemes)->get() as $scheme)
        <td width="100%" style="text-align: center">
            <img src="{{ $scheme->schema }}" width="50%">
        </td>
        @endforeach
    </tr>
</table>
<table width="100%" style="" border="0">
    <tr>
        <td width="100%">
        <h2>Graph</h2>
        </td>
    </tr>
    <tr>
        <td width="100%">
           <img src="{{ $imgResult }}" width="80%"> 
        </td>
    </tr>
</table>
<table width="100%" style="" border="0">
        @foreach($history as $key => $param)
        <tr>
            <td width="100%" style="padding:10px;"><strong>Comparison {{ $key+1 }} parameters</strong></td>
        </tr>
        <tr>
            <td width="100%" style="padding:10px;">
                @foreach($param as $key => $p)
                <strong>{{ $key }}:</strong> {{ $p }},
                @endforeach
            </td>
        </tr>
        @endforeach
</table>