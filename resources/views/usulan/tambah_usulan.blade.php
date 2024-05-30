@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column gap-5">
        <div class="row pt-5 mb-3">
            <div class="m-0 p-0 row col d-flex align-items-center justify-content-between">
                <h3>Buat Usulan Penelitian</h3>
                <p class="mb-0">Home / Daftar Usulan / Buat Usulan Penelitian</p>
            </div>
        </div>
    </div>
    <div class="container mb-1">
        <div class="row">
            <div class="col">
                <div class="card card-outline">
                    <div class="card-header">
                        <h4 class="card-title"><b>Tahap Pengajuan</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row gx-5">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="p-3 border border-success bg-light">
                                    <div class="d-flex align-items-center" style="gap: 10px">
                                        <div class="bg-success px-3 pt-1">
                                            <h5>1</h5>
                                        </div>
                                        <h5>Judul Penelitian dan Anggota</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="p-3 border bg-light {{ $data['step'] >= 2 ? 'border-success' : '' }}">
                                    <div class="d-flex align-items-center" style="gap: 10px">
                                        <div class="px-3 pt-1 {{ $data['step'] >= 2 ? 'bg-success' : 'bg-secondary' }}">
                                            <h5>2</h5>
                                        </div>
                                        <h5>Pendanaan</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <div class="p-3 border bg-light {{ $data['step'] >= 3 ? 'border-success' : '' }}">
                                    <div class="d-flex align-items-center" style="gap: 10px">
                                        <div class="px-3 pt-1 {{ $data['step'] >= 3 ? 'bg-success' : 'bg-secondary' }}">
                                            <h5>3</h5>
                                        </div>
                                        <h5>Luaran dan Finalisasi</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
                                <div>
                                    <table class="table table-bordered" id="tableDosen">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="bg-success text-center">Mahasiswa</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center col-2">
                                                    <button type="button" class="btn btn-success"
                                                        onclick="addMhs()"><b>+</b></button>
                                                </th>
                                                <th class="text-center col-10">Nama Mahasiswa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="isiMhs">
                                            <td colspan="2">
                                                <select class="custom-select" name="anggota_mhs[0]">
                                                    <option selected>Pilih Mahasiswa</option>
                                                    @foreach ($data['data_mhs'] as $item)
                                                        <option value="{{ $item->mhs_id }}">
                                                            ({{ $item->mhs_id }})
                                                            {{ $item->mhs_nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mb-1">
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <button class="btn w-100 btn-primary"><b>Simpan dan Lanjutkan</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    @if ($data['step'] == '2')
        <!-- step 2 -->
        <form action="">
            <div class="container mb-1">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Komponen Pendanaan</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            <h5><b>Perhatian</b></h5>
                            <p class="m-0 p-0">Tuliskan rincian masing-masing komponen pendanaan pada berkas proposal yang
                                anda
                                unggah.</p>
                        </div>
                        <form>
                            <div class="row form-group-row p-3">
                                <div class="col-sm">
                                    <label>Total Pendanaan <span style="color: red">*</span></label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="">
                                    <p><b>Petunjuk: masukkan total dana penelitian yang diajukan.</b></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row form-group-row p-3">
                                <div class="col-sm">
                                    <label>Bahan habis pakai dan peralatan<span style="color: red">*</span> (Maks. <span
                                            style="color: red">60%</span>)</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="row form-group-row p-3">
                                <div class="col-sm">
                                    <label>Perjalanan<span style="color: red">*</span> (Maks. <span
                                            style="color: red">30%</span>)</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="row form-group-row p-3">
                                <div class="col-sm">
                                    <label>Lain-lain<span style="color: red">*</span> (Maks. <span
                                            style="color: red">40%</span>)</label>
                                    <p style="font-size: 13px">publikasi, seminar, laporan, lainnya</p>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container mb-1">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-warning"><b>Kembali</b></button>
                            <button type="button" class="btn btn-primary"><b>Lanjutkan>></b></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    @endif

    @if ($data['step'] == '3')
        <!-- step 3 -->
<form action="">
    <div class="row mb-1">
    <div class="col">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h4 class="card-title"><b>Capaian</b></h4>
        </div>
        <div class="card-body">
            <div class="row form-group-row mt-3">
                <div class="col-sm">
                    <label>Luaran Tambahan<b class="text-danger">*</b></label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row form-group-row mt-3">
                <div class="col-sm">
                    <label>IKU<b class="text-danger">*</b></label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="col">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h4 class="card-title"><b>Berkas Usulan</b></h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="proposalFile">Proposal <sup class="text-danger">(PDF)*</sup></label>
                        <input type="file" class="form-control" id="proposalFile">
                    </div>

                    <div class="form-group">
                    <label for="rabFile">Rencana Anggaran Biaya (RAB) <sup class="text-danger">(PDF)*</sup></label>
                    <input type="file" class="form-control" id="rabFile">
                    </div>
                </div>
            </div>
        </div>

<div class="container mb-1">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col">
                        <button type="button" class="btn btn-warning"><b>Kembali</b></button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary"><b>Simpan Draft</b></button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-success"><b>Simpan Permanen</b></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </form>
    @endif
=======
    @yield('step')
>>>>>>> ba2b3c08c775baf98ab107d8200ac873be5f0963
@endsection
