<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kameras - SantriKoding.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body style="background: lightgray">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <a href="{{ route('kameras.create') }}" class="btn btn-md btn-success mb-3">TAMBAH KAMERA</a>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">GAMBAR</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">BRAND</th>
                            <th scope="col">HARGA</th>
                            <th scope="col">STOCK</th>
                            <th scope="col">AKSI</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($kameras as $kamera)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ Storage::url('public/kameras/').$kamera->image }}" class="rounded" style="width: 150px">
                                </td>
                                <td>{{ $kamera->nama }}</td>
                                <td>{!! $kamera->brand !!}</td>
                                <td>{!! $kamera->harga !!}</td>
                                <td>{!! $kamera->stock !!}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('kameras.destroy', $kamera->id) }}" method="POST">
                                        <a href="{{ route('kameras.edit', $kamera->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Kamera belum Tersedia.
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $kameras->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    //message with toastr
    @if(session()->has('success'))

    toastr.success('{{ session('success') }}', 'BERHASIL!');

    @elseif(session()->has('error'))

    toastr.error('{{ session('error') }}', 'GAGAL!');

    @endif
</script>

</body>
</html>
