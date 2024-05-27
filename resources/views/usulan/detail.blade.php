@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column gap-5">
    <div class="row pt-5 mb-3">
        <div class="m-0 p-0 row col d-flex align-items-center justify-content-between">
            <h3>Detail Usulan</h3>
            <p class="mb-0">Home / Detail Usulan</p>
        </div>
    </div>
</div>
<div class="container mt-3 d-flex justify-content-end">
    <button class="btn btn-warning"><b>Kembali</b></button>
</div>
<div class="row mt-4">
    <div class="col-lg-5">
        <div class="card card-outline card-primary">
            <div class="card-header"><b>Data Penelitian</b></div>
            <div class="card-body">
                <form>
                    <div class="row form-group-row">
                        <div class="col-12 col-lg-4">
                            <label>Skema</label>
                        </div>
                        <div class="col">
                            <input type="text" name="skemaid" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Judul <b class="text-danger">*</b></label>
                        </div>
                        <div class="col">
                            <input type="text" name="skemaid" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Abstrak <b class="text-danger">*</b></label>
                        </div>
                        <div class="col">
                            <textarea class="form-control" id="abstrak" name="abstrak" disabled></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header"><b>Capaian</b></div>
            <div class="card-body">
                <form>
                    <div class="row form-group-row">
                        <div class="col-12 col-lg-4">
                            <label>Luaran Wajib</label>
                        </div>
                        <div class="col">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Jenis Luaran Wajib</th>
                                        <th>Luaran</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Luaran Tambahan</label>
                        </div>
                        <div class="col">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Jenis Luaran Tambahan</th>
                                        <th>Luaran</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>IKU</label>
                        </div>
                        <div class="col">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th class="col-6">IKU</th>
                                        <th class="col-2">Target Pengusul</th>
                                        <th>Bukti</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-outline card-primary">
            <div class="card-header"><b>Anggota</b></div>
            <div class="card-body">
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="bg-success text-center">Dosen Politeknik Negeri Semarang</th>
                            </tr>
                            <tr>
                                <th class="text-center col-7">Nama Dosen</th>
                                <th class="text-center col-5">Status Verifikasi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3" class="bg-success text-center">Dosen Luar</th>
                            </tr>
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Institusi</th>
                                <th class="text-center">Negara</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3" class="bg-success text-center">Mahasiswa</th>
                            </tr>
                            <tr>
                                <th class="text-center col-3">NIM</th>
                                <th class="text-center col-5">Nama</th>
                                <th class="text-center col-4">Program Studi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header"><b>Berkas Usulan</b></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center col-1">No</th>
                            <th class="text-center col-5">Berkas</th>
                            <th class="text-center col-3">Lihat Berkas</th>
                            <th class="text-center col-3">Status Berkas</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header"><b>Komponen Pendanaan</b></div>
            <div class="card-body">
                <form>
                    <div class="row form-group-row">
                        <div class="col-12 col-lg-4">
                            <label>Total Pendanaan</label>
                        </div>
                        <div class="col">
                            <input type="text" name="skemaid" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Bahan habis pakai dan peralatan <span class="text-danger">*</span> (Maks. <span class="text-danger">60%</span>)</label>
                        </div>
                        <div class="col">
                            <input type="text" name="skemaid" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Perjalanan <span class="text-danger">*</span> (Maks. <span class="text-danger">30%</span>)</label>
                        </div>
                        <div class="col">
                            <input type="text" name="skemaid" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Lainnya <span class="text-danger">*</span> (Maks. <span class="text-danger">40%</span>)</label>
                            <p>publikasi, seminar, laporan, lainnya</p>
                        </div>
                        <div class="col">
                            <input type="text" name="skemaid" class="form-control" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-blue">10 Februari 2024</span>
                        </div>
                        <div>
                        <i class="fas fa-check bg-yellow"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                            <h3 class="timeline-header">Draft</h3>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-check bg-green"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                            <h3 class="timeline-header">Diusulkan</h3>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection