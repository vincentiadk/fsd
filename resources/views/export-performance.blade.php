<table>
    <thead>
        <tr>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                No</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Nama User</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Role</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Upload</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Benar</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Salah</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Tolak</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                QC</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Indexing</th>
            <th
                style="height:25px; font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Tuntas</th>
        </tr>
    </thead>
    <tbody>
        @if(count($data) > 0)
        @php $no = 1; @endphp
        @foreach($data['data'] as $key => $d)
        <tr>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $no }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[0] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[1] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[2] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[3] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[4] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[5] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[6] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[7] }}
            </td>
            <td style="font-size:9px; border:1px solid black; text-align:center; vertical-align:center;">
                {{ $d[8] }}
            </td>
        </tr>
        @php $no++;  @endphp
        @endforeach
       
        @else
        <tr>
            <td colspan="63"
                style="font-size:10px; font-weight:bold; border:1px solid black; text-align:center; vertical-align:center;">
                Tidak Ada Data</td>
        </tr>
        @endif
    </tbody>
</table>