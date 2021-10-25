<script src="{{ asset('js/sweetalert2.js') }}"></script>

{{-- Director Controller --}}
@if (Session::has('message') && Session::get('message') == 'assignment-not-found')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Penugasan Salah!',
            text: 'Data Penugasan Tidak Ditemukan',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'success-approve-assignment')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Menyetujui Penugasan!',
            text: 'Berhasil Menyetujui Penugasan',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'success-decline-assignment')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Menolak Penugasan!',
            text: 'Berhasil Menolak Penugasan',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'unknown-approve-assignment')
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Menyetujui Penugasan!',
            text: 'Berhasil Menyetujui Penugasan',
            showConfirmButton: true,
        })
    </script>
@endif
