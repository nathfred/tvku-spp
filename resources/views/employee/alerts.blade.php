<script src="{{ asset('js/sweetalert2.js') }}"></script>

{{-- Employee Controller --}}
@if (Session::has('message') && Session::get('message') == 'assignment-not-found')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Penugasan Salah!',
            text: 'Data Penugasan Tidak Ditemukan',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'success-submit-assignment')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Disubmit!',
            text: 'Data Penugasan Berhasil Disubmit',
            showConfirmButton: true,
        })
    </script>

{{-- Assignment Controller --}}
@elseif (Session::has('message') && Session::get('message') == 'success-delete-assignment')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Menghapus Penugasan!',
            text: 'Berhasil Menghapus Data Penugasan',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'success-create-assignment')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Membuat Penugasan!',
            text: 'Berhasil Membuat Penugasan Baru',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'success-edit-assignment')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Merubah Penugasan!',
            text: 'Berhasil Merubah Data Penugasan',
            showConfirmButton: true,
        })
    </script>
@elseif (Session::has('message') && Session::get('message') == 'assignment-already-nspp')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Nomor SPP Sudah Terpakai!',
            text: 'Penugasan Dengan Nomor SPP dan Jenis Ini Sudah Ada Di Tahun Ini',
            showConfirmButton: true,
        })
    </script>

@endif
