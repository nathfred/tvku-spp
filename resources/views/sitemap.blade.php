<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<spp>
    <tanggal_dibuat>{{ $assignment->created }}</tanggal_dibuat>
    <jenis>{{ $assignment->type }}</jenis>
    <klien>{{ $assignment->client }}</klien>
    <nomor_spp>{{ $assignment->nspp }}</nomor_spp>
    <nomor_spk>{{ $assignment->nspk }}</nomor_spk>
    <invoice>{{ $assignment->invoice }}</invoice>
    <keterangan>{{ $assignment->description }}</keterangan>
    <nominal>{{ $assignment->nominal }}</nominal>
    <beban_marketing>{{ $assignment->marketing_expense }}</beban_marketing>
    <deadline>{{ $assignment->deadline }}</deadline>
    <prioritas>{{ $assignment->priority }}</prioritas>
    <disetujui>{{ $assignment->approve }}</disetujui>
    <tanggal_disetujui>{{ $assignment->approval_date }}</tanggal_disetujui>
</spp>
