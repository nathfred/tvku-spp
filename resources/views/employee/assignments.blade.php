@extends('layouts.employee.app')

@section('content')
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
                    Tabel Daftar Penugasan
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal Dibuat</th>
                                <th>No. SPP</th>
                                <th>No. SPK</th>
                                <th>Klien</th>
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
                                        <td>{{ $assignment->nspp }}</td>
                                        <td>{{ $assignment->nspk }}</td>
                                        <td>{{ $assignment->client }}</td>
                                        <td>{{ $assignment->deadline }}</td>
                                        <!-- Priority -->
                                        @if ($assignment->priority === NULL || $assignment->priority == '')
                                            <td>-</td>
                                        @else
                                            <td>{{ $assignment->priority }}</td>
                                        @endif
                                        <!-- Submit -->
                                        @if ($assignment->submit === NULL || $assignment->submit == 0 || $assignment->submit == '0')
                                            <td><p class="btn-warning text-center text-white mt-0 mb-0">Belum</p></td>
                                        @else
                                            <td><p class="btn-primary text-center mt-0 mb-0">Sudah</p></td>
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
                                            @elseif ($assignment->submit == 1)
                                                <a href="{{ route('employee-submit-assignment', ['submit' => 0, 'id' => $assignment->id]) }}" class="btn btn-warning"><i class="bi bi-dash-square"></i></a>
                                            @endif
                                            @if ($assignment->type == 'Free')
                                                <a href="{{ route('create-pdf-free', ['id' => $assignment->id]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                            @elseif ($assignment->type == 'Berbayar')
                                                <a href="{{ route('create-pdf-paid', ['id' => $assignment->id]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                            @elseif ($assignment->type == 'Barter')
                                                <a href="{{ route('create-pdf-barter', ['id' => $assignment->id]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                            @endif
                                            <a href="{{ route('employee-delete-assignment', ['id' => $assignment->id]) }}" class="btn btn-danger"><i class="bi bi-x-square"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td align='center' colspan='10'>Tidak ada Penugasan</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

    <script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

@include('employee.alerts')

@endsection