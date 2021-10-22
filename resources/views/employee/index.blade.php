@extends('layouts.employee.app')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Penugasan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_assignment }} Dokumen</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Sudah Direspon</h6>
                                        <h6 class="font-extrabold mb-0">{{ $responded_assignment }} Dokumen</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldDanger"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Belum Direspon</h6>
                                        <h6 class="font-extrabold mb-0">{{ $unresponded_assignment }} Dokumen</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldPaper-Plus"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Dibuat Hari Ini</h6>
                                        <h6 class="font-extrabold mb-0">{{ $today_assignment }} Dokumen</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="font-weight-bold text-uppercase">Tabel Daftar Penugasan (Belum Direspon)</p>
                            </div>
                            <div class="card-body mt-0 pt-0">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Jenis</th>
                                            <th>No. SPP</th>
                                            <th>No. SPK</th>
                                            <th>Klien</th>
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
                                                    <td>{{ $assignment->client }}</td>
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
                                                        <a href="{{ route('employee-edit-assignment', ['type' => $assignment->type, 'id' => $assignment->id]) }}" class="btn btn-info"><i class="bi bi-arrow-left-square"></i></a>
                                                        @if ($assignment->type == 'Free')
                                                            <a href="{{ route('create-pdf-free', ['id' => $assignment->id]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                                        @elseif ($assignment->type == 'Berbayar')
                                                            <a href="{{ route('create-pdf-berbayar', ['id' => $assignment->id]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                                        @elseif ($assignment->type == 'Barter')
                                                            <a href="{{ route('create-pdf-barter', ['id' => $assignment->id]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td align='center' colspan='10'>Tidak Ada Pengajuan</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                {{-- <img src="{{ asset('images/faces/male') }}.png"> --}}
                                <i class="fas fa-grin-alt" style="width:50px; height:50px;"></i>
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ $user->name }}</h5>
                                <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-haspopup="true" aria-expanded="false">{{ $user->email }}</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/logout" style="width:50px">Log Out</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Pengajuan Terbaru</h4>
                    </div>
                    <div class="card-content pb-4">
                        @if ($recent_assignments->isNotEmpty())
                            @foreach ($recent_assignments as $assignment)
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="avatar avatar-lg">
                                        @if ($assignment->type == 'Free')
                                            <img src="{{ asset('img/free') }}.png">
                                        @elseif ($assignment->type == 'Berbayar')
                                            <img src="{{ asset('img/berbayar') }}.png">
                                        @elseif ($assignment->type == 'Barter')
                                            <img src="{{ asset('img/barter') }}.png">
                                        @endif
                                    </div>
                                    <div class="name ms-4">
                                        <h5 class="mb-1">No. SPP : {{ $assignment->nspp }} ({{ $assignment->type }})</h5>
                                        <h6 class="text-muted mb-0">Deadline : {{ $assignment->created }}</h6>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="px-4">
                            <a href="{{ route('director-show-assignments') }}" class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>Lebih Lanjut</a>
                        </div>
                    </div>
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
@endsection