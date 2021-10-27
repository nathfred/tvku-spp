<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<spp>
    <created>{{ $assignment->created }}</created>
    <type>{{ $assignment->type }}</type>
    <client>{{ $assignment->client }}</client>
    <nspp>{{ $assignment->nspp }}</nspp>
    <nspk>{{ $assignment->nspk }}</nspk>
    <description>{{ $assignment->description }}</description>
    <nominal>{{ $assignment->nominal }}</nominal>
    <deadline>{{ $assignment->deadline }}</deadline>
    <priority>{{ $assignment->priority }}</priority>
    <approval>{{ $assignment->approve }}</approval>
    <approval_date>{{ $assignment->approval_date }}</approval_date>
</spp>
