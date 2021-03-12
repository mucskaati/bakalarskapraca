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
           <h3> Scheme </h3>
        </td>
    </tr>
</table>
@if($img)
<table width="100%" style="" border="0">
    <tr>
        <td width="100%">
            <img src="{{ $img->getAttribute('src') }}" alt="scheme" width="50%">
        </td>
    </tr>
    <tr>
    </tr>
</table>
@endif
<table style="" border="0">
    <tr>
        <td>
            <h2>Parameters:</h2>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td width="30%">
            <table width border="0">
                    @foreach($params as $key => $param)
                    <tr>
                        <td width="100%" style="padding:10px;">
                            <strong>{{ $key }}:</strong> {{ $param }}
                        </td>
                    </tr>
                    @endforeach
            </table>
        </td>
        <td width="80%" style="vertical-align: top;text-align:center">
            <img src="{{ $imgResult }}" width="80%">
        </td>
    </tr>
</table>