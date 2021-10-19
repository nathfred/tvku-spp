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
                    <div class="row">
                        <div class="col">
                            <h3>Buat Penugasan</h3>
                        </div>
                    </div>
                    <p class="text-subtitle text-muted">Buat Penugasan Baru ({{ $type }})</p>
                </div>
            </div>
        </div>

        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Input Data Penugasan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST" action="{{ route('employee-store-assignment', ['type' => $type]) }}">
                                    @csrf
                                    @method('POST')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tanggal Pembuatan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="date" id="created" class="form-control" name="created" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Client</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="client" class="form-control" name="client" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>No. SPP</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="nspp" class="form-control" name="nspp" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>No. SPK</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                @if ($type == 'Free')
                                                    <input type="text" id="nspk" class="form-control" name="nspk" disabled>
                                                @else
                                                    <input type="text" id="nspk" class="form-control" name="nspk" required>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label>Keterangan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="description" class="form-control" name="description" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Deadline</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="deadline" class="form-control" name="deadline" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="info" class="form-label">Info Waktu Produksi/Penayangan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <textarea class="form-control" id="info" name="info" rows="7" required></textarea>
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <a href="javascript:history.back()" class="btn btn-secondary me-1 mb-1">Cancel</a>
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Confirm</button>
                                            </div>
                                            @if ($errors->any())
                                                <div class="alert alert-danger mt-4">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-body py-4 px-5">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    @if ($user->gender == "male")
                                        <img src="{{ asset('images/faces/male') }}.png">
                                    @elseif ($user->gender == "female")
                                        <img src="{{ asset('images/faces/female') }}.png">
                                    @else
                                        <img src="{{ asset('images/faces/male') }}.png">
                                    @endif
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold">{{ $user->name }}</h5>
                                    <!--<h6 class="text-muted mb-0">{{ $user->email }}</h6>-->
                                    <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"aria-haspopup="true" aria-expanded="false">{{ $user->email }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Pegawai</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @if ($employee === NULL)
                                @else
                                    <form class="form form-horizontal" method="POST" action="{{ route('super-edit-employee', ['id' => $employee->id]) }}">
                                        @csrf
                                        @method('POST')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>NPP</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    @if ($already_employee == "TRUE")
                                                        <input type="text" id="npp" class="form-control" name="npp" value="{{ $employee->npp }}" >
                                                    @elseif ($already_employee == "FALSE")
                                                        <input type="text" id="npp" class="form-control" name="npp" required>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Jabatan</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="position" id="position" value="Manager" required {{ ($employee->position == "Manager") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="position">Manager</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="position" id="position" value="Kepala" {{ ($employee->position == "Kepala") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="position">Kepala</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="position" id="position" value="Staff" {{ ($employee->position == "Staff") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="position">Staff</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Divisi</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="IT" required {{ ($employee->division == "IT") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">IT</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="Keuangan" {{ ($employee->division == "Keuangan") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">Keuangan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="Produksi" {{ ($employee->division == "Produksi") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">Produksi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="Teknikal Support" {{ ($employee->division == "Teknikal Support") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">Teknik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="Marketing" {{ ($employee->division == "Marketing") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">Marketing</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="Human Resources" {{ ($employee->division == "Human Resources") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">Human Resources</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="News" {{ ($employee->division == "News") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">News</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="division" id="division" value="Umum" {{ ($employee->division == "Umum") ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="division">Umum</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Tahun Bergabung</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    @if ($already_employee == "TRUE")
                                                        <input type="text" id="joined" class="form-control" name="joined" value="{{ $employee->joined }}" >
                                                    @elseif ($already_employee == "FALSE")
                                                        <input type="text" id="joined" class="form-control" name="joined" required>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="id" value="{{ $employee->id }}">
                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">Confirm</button>
                                                </div>
                                                @if ($errors->any())
                                                    <div class="alert alert-danger mt-4">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>

    </div>

@include('employee.alerts')

@endsection