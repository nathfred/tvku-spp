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
                    <div class="row">
                        <div class="col">
                            <h3>Detail Penugasan</h3>
                        </div>
                    </div>
                    <p class="text-subtitle text-muted">Data Penugasan ({{ $type }})</p>
                </div>
            </div>
        </div>

        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detail Data Penugasan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST" action="{{ route('director-save-assignment', ['type' => $type, 'id' => $assignment->id]) }}">
                                    @csrf
                                    @method('POST')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Tanggal Pembuatan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="date" id="created" class="form-control" name="created" value="{{ $assignment->created }}" disabled>
                                            </div>
                                            {{-- @if ($type != 'Free') --}}
                                                <div class="col-md-4">
                                                    <label>Client</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="client" class="form-control" name="client" value="{{ $assignment->client }}" disabled>
                                                </div>
                                            {{-- @endif --}}
                                            <div class="col-md-4">
                                                <label>No. SPP</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="nspp" class="form-control" name="nspp" value="{{ $assignment->nspp }}" disabled>
                                            </div>
                                            @if ($type != 'Free')
                                                <div class="col-md-4">
                                                    <label>No. SPK</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    @if ($type == 'Free' || !$assignment->nspk === NULL )
                                                        <input type="text" id="nspk" class="form-control" name="nspk" disabled>
                                                    @else
                                                        <input type="text" id="nspk" class="form-control" name="nspk" value="{{ $assignment->nspk }}" disabled>
                                                    @endif
                                                </div>
                                            @endif
                                            {{-- @if ($type != 'Free') --}}
                                                <div class="col-md-4">
                                                    <label>Keterangan</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="description" class="form-control" name="description" value="{{ $assignment->description }}" disabled>
                                                </div>
                                            {{-- @endif --}}
                                            @if ($type == 'Berbayar')
                                                <div class="col-md-4">
                                                    <label>Nominal</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="nominal" class="form-control" name="nominal" value="{{ $assignment->nominal }}" disabled>
                                                </div>
                                            @endif
                                            @if ($type == 'Berbayar')
                                                <div class="col-md-4">
                                                    <label>Beban Marketing</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="marketing_expense" class="form-control" name="marketing_expense" value="{{ $assignment->marketing_expense }}" disabled>
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <label>Deadline</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="deadline" class="form-control" name="deadline" value="{{ $assignment->deadline }}" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="info" class="form-label">Info Waktu Produksi/Penayangan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <textarea class="form-control" id="info" name="info" rows="7" disabled>{{ $assignment->info }}</textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Prioritas</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="priority" id="priority" value="Biasa" {{ ($assignment->priority == "Biasa") ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="priority">Biasa</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="priority" id="priority" value="Penting" {{ ($assignment->priority == "Penting") ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="priority">Penting</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="priority" id="priority" value="Sangat Penting" {{ ($assignment->priority == "Sangat Penting") ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="priority">Sangat Penting</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Approval</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approval" id="approval" value="1" {{ ($assignment->approval == 1) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="approval">Approve</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approval" id="approval" value="0" {{ ($assignment->approval == 0 && !empty($assignment->approval_date)) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="approval">Decline</label>
                                                </div>
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