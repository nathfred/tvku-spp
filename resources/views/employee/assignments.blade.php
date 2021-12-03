@extends('layouts.employee.app')

@section('content')
    <style>
        thead input {
            width: 100%;
        }
    </style>

    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Penugasan</h3>
                    <p class="text-subtitle text-muted">Daftar Penugasan</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row bd-highlight">
                        <div class="btn-group mb-1">
                            <div class="dropdown">
                                <button class="btn btn-info rounded-pill dropdown-toggle me-1" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    SPP Tahunan
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach ($years as $year)
                                        <a class="dropdown-item" href="{{ route('employee-show-assignments',['year'=>$year]) }}">{{ $year }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal Dibuat</th>
                                <th>Jenis</th>
                                <th>No. SPP</th>
                                <th>No. SPK</th>
                                <th>Klien</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                                <th>Prioritas</th>
                                <th>Submit</th>
                                <th>Acc Direktur</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @if ($assignments->isNotEmpty())
                                @foreach ($assignments as $assignment)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td>{{ $assignment->created }}</td>
                                        <td>{{ $assignment->type }}</td>
                                        <td>{{ $assignment->nspp }}</td>
                                        @if ($assignment->nspk === NULL || $assignment->nspk == '')
                                            <td>-</td>
                                        @else
                                            <td>{{ $assignment->nspk }}</td>
                                        @endif
                                        @if ($assignment->client === NULL || $assignment->client == '')
                                            <td>-</td>
                                        @else
                                            <td>{{ $assignment->client }}</td>
                                        @endif
                                        @if ($assignment->type == 'Berbayar')
                                            <td>{{ $assignment->nominal_expense }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $assignment->deadline }}</td>
                                        <!-- Priority -->
                                        @if ($assignment->priority === NULL || $assignment->priority == '')
                                            <td>-</td>
                                        @else
                                            <td>{{ $assignment->priority }}</td>
                                        @endif
                                        <!-- Submit -->
                                        @if ($assignment->submit === NULL || $assignment->submit == 0 || $assignment->submit == '0')
                                            <td><p class="btn-warning text-center rounded text-white mt-0 mb-0">Belum</p></td>
                                        @else
                                            <td><p class="btn-primary text-center rounded mt-0 mb-0">Sudah</p></td>
                                        @endif
                                        <!-- Approval -->
                                        @if ($assignment->approval === NULL || $assignment->approval == '')
                                            <td>-</td>
                                        @elseif ($assignment->approval == '0' || $assignment->approval == 0)
                                            <td><p class="btn-danger text-center text-white mt-0 mb-0">DITOLAK</p></td>
                                        @elseif ($assignment->approval == '1' || $assignment->approval == 1)
                                            <td><p class="btn-success text-center mt-0 mb-0">DITERIMA</p></td>
                                        @endif
                                        <!-- Aksi -->
                                        <td>
                                            <a href="{{ route('employee-edit-assignment', ['type' => $assignment->type, 'id' => $assignment->id]) }}" class="btn btn-info"><i class="bi bi-arrow-left-square"></i></a>
                                            @if ($assignment->submit == 0)
                                                <a href="{{ route('employee-submit-assignment', ['submit' => 1, 'id' => $assignment->id]) }}" class="btn btn-primary"><i class="bi bi-check-square"></i></a>
                                            @elseif ($assignment->submit == 1 && (!$assignment->approval))
                                                <a href="{{ route('employee-submit-assignment', ['submit' => 0, 'id' => $assignment->id]) }}" class="btn btn-warning"><i class="bi bi-dash-square"></i></a>
                                            @endif
                                            @if ($assignment->type == 'Free')
                                                {{-- <a href="{{ route('create-pdf-free', ['id' => $assignment->id]) }}" target="_blank" class="btn btn-success"><i class="bi bi-printer-fill"></i></a> --}}
                                                <a href="{{ route('show-pdf', ['id' => $assignment->id]) }}" target="_blank" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                            @elseif ($assignment->type == 'Berbayar')
                                                {{-- <a href="{{ route('create-pdf-berbayar', ['id' => $assignment->id]) }}" target="_blank" class="btn btn-success"><i class="bi bi-printer-fill"></i></a> --}}
                                                <a href="{{ route('show-pdf', ['id' => $assignment->id]) }}" target="_blank" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                            @elseif ($assignment->type == 'Barter')
                                                {{-- <a href="{{ route('create-pdf-barter', ['id' => $assignment->id]) }}" target="_blank" class="btn btn-success"><i class="bi bi-printer-fill"></i></a> --}}
                                                <a href="{{ route('show-pdf', ['id' => $assignment->id]) }}" target="_blank" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                            @endif
                                            {{-- <a href="{{ route('employee-delete-assignment', ['id' => $assignment->id]) }}" class="btn btn-danger"><i class="bi bi-x-square"></i></a> --}}
                                            <button class="btn btn-danger" onclick="delete_confirm('{{ $assignment->id }}')"><i class="bi bi-x-square"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td align='center' colspan='12'>Tidak ada Penugasan</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

    <script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
    {{-- <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script> --}}

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    {{-- <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.fixedHeader.min.js.js') }}"></script> --}}

    {{-- simple-datatables --}}
    {{-- <script>
        // $('#table1 thead tr')
        //     .clone(true)    
        //     .addClass('filters')
        //     .appendTo('#table1 thead');

        let table = new simpleDatatables.DataTable('#table1', {
            orderCellsTop: true,
                fixedHeader: true,
                initComplete: function () {
                    var api = this.api();
        
                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');
        
                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
        
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();
        
                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
        
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
        });
    </script> --}}

    {{-- Datatables --}}
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#table1 thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#table1 thead');
        
            var table = $('#table1').DataTable({
                responsive: true,
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function () {
                    var api = this.api();
        
                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');
        
                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
        
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();
        
                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
        
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
    </script>

    <script>
        function delete_confirm(assignment_id) {
            var assignment_id = assignment_id;
            var url = '{{ route("employee-delete-assignment", ":slug") }}';
            url = url.replace(':slug', assignment_id);
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Aksi ini tidak dapat diulangi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus pengajuan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Terhapus!',
                        text: 'Berhasil Menghapus Data Penugasan',
                        showConfirmButton: true,
                    })
                }
            })
        }
    </script>

@include('employee.alerts')

@endsection