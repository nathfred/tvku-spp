<!DOCTYPE html>
<html lang="en">
<head>
    <title>Surat Perintah Penugasan</title>

    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app-mazer.css') }}"> --}}
    <link rel="shortcut icon" href="{{ asset('img/tvku_favicon.png') }}" type="image/x-icon">
</head>
<body>
    <style>
        img {
            position: absolute;
            
        }
        #table2{
            border: none;
            border-collapse: collapse;
        }
        #table1{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th,td{
            padding: 5px;
        }
        </style>
        <img src="{{ asset('img/tvku_logo_spp.jpg') }}" style="height: auto; width: 100px;">
        <table id="table2" style="width: 100%" align="center">
            <tr>
                <td style="line-height: 1.2em; align=center; padding-left: 110px;">
                    <span style="line-height:1.6; font-weight:bold;	font-size: 16px;">
                        PT.TELEVISI KAMPUS UNIVERSITAS DIAN NUSWANTORO
                    </span>
                    <p style="margin: 0px; padding: 0px;">Jl.Nakula I No.5-11 Semarang</p>
                </td>
            </tr>
        </table>
        <center>
            <h3 style="margin-bottom: 0px; padding-bottom:0px;"><b><u>SURAT PERINTAH PENUGASAN</u></b></h3>
            <p style="margin-top: 0px; padding-top:0px;">No. {{ $assignment->nspp }}/SPP-D/{{ $assignment->month_roman }}/TVKU/{{ $assignment->year }}</p>
        </center>
        
        <br>Berdasarkan :<br>
        SPK Nomor {{ $assignment->nspk }} ({{ $assignment->client }} - {{ $assignment->description }})<br>
        
        <br>Invoice Nomor I-{{ $assignment->nspp }}/KEU/TVKU/{{ $assignment->month_roman }}/{{ $assignment->year }}<br>
        <br>
        Dengan ini menugaskan Direktur Operasional untuk melakukan produksi maupun penayangan dengan ketentuan sebagai berikut:<br>
        <br>
        <table id="table1" style="width:100%; border: 1px solid black;">
            <tr>
                <td style="width:35%; border-collapse: collapse; border:1px solid black;">Deadline Pengerjaan</td>
                <td style="border-collapse: collapse; border:1px solid black;"> {{ $assignment->deadline }}</td>
            </tr>
            <tr>
                <td style="width:35%; border-collapse: collapse; border: 1px solid black;">Info Waktu Produksi/Penayangan</td>
                {{-- <td style="border-collapse: collapse; border:1px solid black;"><textarea rows="10" cols="50">{{ $assignment->info }}</textarea></td> --}}
                {{-- <td style="border-collapse: collapse; border:1px solid black;">{{ $assignment->info }}</td> --}}
                <td style="border-collapse: collapse; border:1px solid black;">
                    @foreach ($assignment->array_info as $line)
                        {{ $line }}<br>
                    @endforeach
                </td>
            </tr>
        </table>
        <br>
        Status Prioritas :<br>
        <input type="checkbox" id="myCheck" {{ ($assignment->priority == 'Sangat Penting') ? 'checked' : '' }}>
        <label for="myCheck">Sangat Penting</label><br>
        <input type="checkbox" id="myCheck" {{ ($assignment->priority == 'Penting') ? 'checked' : '' }}>
        <label for="myCheck">Penting</label><br>
        <input type="checkbox" id="myCheck" {{ ($assignment->priority == 'Biasa') ? 'checked' : '' }}>
        <label for="myCheck">Biasa</label><br>
        <br>
        Agar dilaksanakan sebaik-baiknya dengan penuh tanggung jawab <br>
        <br>
        Semarang, {{ $assignment->created }}
        <br><br>
        Direktur Utama<br>
        PT. Televisi Kampus Udinus<br>
        <br>
        <br>
        <br>
        <br>
        Dr. Guruh Fajar Shidik, S.Kom, M.CS<br>
        <br>
        Tembusan :<br>
        1. Manager Operasional<br>
        2. Manager Teknik<br>
        3. Manager Marketing<br>

</body>
</html>