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
                            <h3>Edit Penugasan</h3>
                        </div>
                    </div>
                    <p class="text-subtitle text-muted">Edit Penugasan ({{ $type }})</p>
                </div>
            </div>
        </div>

        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Data Penugasan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST" action="{{ route('employee-save-assignment', ['type' => $type, 'id' => $assignment->id]) }}">
                                    @csrf
                                    @method('POST')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>ID</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="id" class="form-control" name="id" value="{{ $assignment->id }}" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Tanggal Pembuatan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="date" id="created" class="form-control" name="created" value="{{ $assignment->created }}" required>
                                            </div>
                                            {{-- @if ($type != 'Free') --}}
                                                <div class="col-md-4">
                                                    <label>Client</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="client" class="form-control" name="client" value="{{ $assignment->client }}" required>
                                                </div>
                                            {{-- @endif --}}
                                            <div class="col-md-4">
                                                <label>No. SPP</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="nspp" class="form-control" name="nspp" value="{{ $assignment->nspp }}" required>
                                            </div>
                                            @if ($type != 'Free')
                                                <div class="col-md-4">
                                                    <label>No. SPK</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    @if ($type == 'Free' || !$assignment->nspk === NULL )
                                                        <input type="text" id="nspk" class="form-control" name="nspk" disabled>
                                                    @else
                                                        <input type="text" id="nspk" class="form-control" name="nspk" value="{{ $assignment->nspk }}" required>
                                                    @endif
                                                </div>
                                            @endif
                                            {{-- @if ($type != 'Free') --}}
                                                <div class="col-md-4">
                                                    <label>Keterangan</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="description" class="form-control" name="description" value="{{ $assignment->description }}" required>
                                                </div>
                                            {{-- @endif --}}
                                            @if ($type == 'Berbayar')
                                                <div class="col-md-4">
                                                    <label>Nominal</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="nominal" class="form-control" name="nominal" value="{{ $assignment->nominal }}" required>
                                                </div>
                                            @endif
                                            @if ($type == 'Berbayar')
                                                <div class="col-md-4">
                                                    <label>Beban Marketing</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="marketing_expense" class="form-control" name="marketing_expense" value="{{ $assignment->marketing_expense }}">
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <label>Deadline</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="deadline" class="form-control" name="deadline" value="{{ $assignment->deadline }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="info" class="form-label">Info Waktu Produksi/Penayangan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <textarea class="form-control" id="info" name="info" rows="7" required>{{ $assignment->info }}</textarea>
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
            </div>
        </section>

    </div>

@include('employee.alerts')

@endsection