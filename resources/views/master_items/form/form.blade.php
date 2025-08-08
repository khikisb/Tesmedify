<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group mb-3">
        <label class="form-label" for="kode_barang">Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" id="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group mb-3">
        <label class="form-label" for="nama">Nama</label>
        <input type="text" class="form-control" name="nama" id="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="harga_beli">Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" id="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="laba">Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" id="laba" required value="{{$item->laba ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="supplier">Supplier</label>
        <select class="form-select" required name="supplier" id="supplier">
            <option @if($item->supplier == '') selected @endif value="">--Pilih--</option>
            <option @if($item->supplier == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($item->supplier == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($item->supplier == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($item->supplier == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($item->supplier == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="jenis">Jenis</label>
        <select class="form-select" required name="jenis" id="jenis">
            <option @if($item->jenis == '') selected @endif value="">--Pilih--</option>
            <option @if($item->jenis == 'Obat') selected @endif>Obat</option>
            <option @if($item->jenis == 'Alkes') selected @endif>Alkes</option>
            <option @if($item->jenis == 'Matkes') selected @endif>Matkes</option>
            <option @if($item->jenis == 'Umum') selected @endif>Umum</option>
            <option @if($item->jenis == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <!-- Input untuk upload foto -->
    <div class="form-group mb-3">
        <label class="form-label" for="foto">Foto</label>
        <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
    </div>

    <!-- Dropdown untuk memilih kategori -->
    <div class="form-group mb-3">
        <label class="form-label" for="kategori">Kategori</label>
        <select name="categories[]" id="kategori" class="form-select" multiple size="5">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" 
                    @if($item->categories && $item->categories->contains($category->id)) selected @endif>
                    {{ $category->nama }} - {{ $category->kode }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>