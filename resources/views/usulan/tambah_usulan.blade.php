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
<!-- step 1 -->
    <form action="">
        <div class="container mb-1">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><b>Peraturan Skema</b></h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Maksimum Keanggotaan (termasuk menjadi Ketua): <b>1</b></li>
                        <li>Maksimum Keanggotaan sebagai Ketua: <b>1</b></li>
                        <li>Jabatan Fungsional Minimum Ketua: <b>Asisten Ahli</b></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Data Penelitian</b></h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row form-group-row">
                                <div class="col-sm">
                                    <label>Skema</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="row form-group-row mt-3">
                                <div class="col-sm">
                                    <label>Judul</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="row form-group-row mt-3">
                                <div class="col-sm">
                                    <label>Abstrak</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="" disabled>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Anggota</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                            <p class="m-0 p-0">Apabila anda menemukan ketidaksesuaian data pribadi (NIP, Nama, Jabatan Fungsional, ID
                            Sinta, NIDN), silakan mengisi aduan pada tautan berikut: https://bit.ly/aduansipmas.</p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <div class="container mb-1">
            <div class="card">
                <div class="card-body d-flex justify-content-end">
                    <button type="button" class="btn btn-primary"><b>Lanjutkan>></b></button>
                </div>
            </div>
        </div>
    </form>
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
                        <p class="m-0 p-0">Tuliskan rincian masing-masing komponen pendanaan pada berkas proposal yang anda unggah.</p>
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
                            <button type="button" class="btn btn-primary"><b>Lanjutkan>></b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!-- step 3 -->
<form action="">
        <div class="row mb-1">
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Capaian</b></h4>
                    </div>
                    <div class="card-body">
                    </div>  
                </div>
            </div>
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Berkas Usulan</b></h4>
                    </div>
                    <div class="card-body">
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
@endsection
