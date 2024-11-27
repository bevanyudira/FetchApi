<div class="container">
        <h4>Tambah Buku</h4>

        @if (count($errors) > 0)
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

        <form method="post" action="{{ route('buku.store') }}" enctype='multipart/form-data'>
            @csrf
            <div>Judul <input type="text" name="judul"></div>
            <div>Penulis <input type="text" name="penulis"></div>
            <div>Harga <input type="text" name="harga"></div>
            <div>Tanggal Terbit <input type="date" name="tgl_terbit"></div>
            <div class="mb-3 row">
                <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                <div class="col-md-6">
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old('photo') }}">
                    @if ($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                </div>
            </div>



            {{-- <div>
                <input type="text" id="tgl_terbit" name="tgl_terbit"
                class="date form-control" placeholder="yyyy/mm/dd">
            </div> --}}


            <button type="submit">Simpan</button>
            <a href="{{'/buku'}}">Kembali</a>
        </form>
</div>

