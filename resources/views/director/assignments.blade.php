@extends('layouts.director.app')

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
                                <th>Jenis</th>
                                <th>No. SPP</th>
                                <th>No. SPK</th>
                                <th>Klien</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                                <th>Prioritas</th>
                                <th>Approval</th>
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
                                            <td>{{ $assignment->nominal }}</td>
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
                                            <a href="{{ route('director-detail-assignment', ['type' => $assignment->type, 'id' => $assignment->id]) }}" class="btn btn-info"><i class="bi bi-arrow-left-square"></i></a>
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
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
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