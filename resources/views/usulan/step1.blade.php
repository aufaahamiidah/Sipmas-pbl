@extends('usulan.tambah_usulan')

@section('step')
    <form @if ($_GET['usulan_id'] != '') action=""  @else action="{{ url('step_0') }}" @endif method="POST">
        @csrf
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
        <div class="container mb-1">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h4 class="card-title"><b>Data Penelitian</b></h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row form-group-row">
                                    <div class="col-12 col-lg-4">
                                        <label>Skema</label>
                                    </div>
                                    <div class="col">
                                        <input type="hidden" name="skema_id" id="skema_id" class="form-control"
                                            value="{{ $data['skema_id'] }}">
                                        <input type="text" name="skemaid" class="form-control"
                                            value="{{ $data['skema_nama'] }}" disabled>
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col-12 col-lg-4">
                                        <label>Judul <b class="text-danger">*</b></label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="judul" id="judul" required
                                            @if ($_GET['usulan_id'] != '') disabled @endif>
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col-12 col-lg-4">
                                        <label>Abstrak <b class="text-danger">*</b></label>
                                    </div>
                                    <div class="col">
                                        <textarea @if ($_GET['usulan_id'] != '') disabled @endif class="form-control" id="abstrak" name="abstrak" required></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h4 class="card-title"><b>Anggota</b></h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-primary" role="alert">
                                <p class="m-0 p-0">Apabila anda menemukan ketidaksesuaian data pribadi (NIP, Nama,
                                    Jabatan
                                    Fungsional, ID
                                    Sinta, NIDN), silakan mengisi aduan pada tautan berikut: <a
                                        href="https://bit.ly/aduansipmas" target="_blank">https://bit.ly/aduansipmas</a>.
                                </p>
                            </div>
                            <div>
                                <table class="table table-bordered" id="tableDosen">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="bg-success text-center">Dosen Politeknik Negeri
                                                Semarang</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center col-2">
                                                <button type="button" class="btn btn-success"
                                                    onclick="addDosen()"><b>+</b></button>
                                            </th>
                                            <th class="text-center col-10">Nama Dosen</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isiDosen">
                                        <tr>
                                            <td colspan="2">
                                                <select class="custom-select" name="anggota_dosen[0]">
                                                    <option selected>Pilih Dosen</option>
                                                    @foreach ($data['data_dosen'] as $item)
                                                        <option value="{{ $item->dosen_id }}">
                                                            ({{ $item->dosen_id }})
                                                            {{ $item->dosen_nama_lengkap }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

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
@endsection

@push('js')
    <script>
        const tbDosen = document.getElementById('isiDosen');
        var count_dosen = 1;
        const tbMhs = document.getElementById('isiMhs');
        var count_mhs = 1;

        function addDosen() {
            let newDosen = `
            <td colspan="2">
                <select class="custom-select" name="anggota_dosen[` + count_dosen + `]">
                    <option selected>Pilih Dosen</option>
                    @foreach ($data['data_dosen'] as $item)
                        <option value="{{ $item->dosen_id }}">
                            ({{ $item->dosen_id }})
                            {{ $item->dosen_nama_lengkap }}</option>
                    @endforeach
                </select>
            </td>
            `;
            tbDosen.innerHTML += newDosen;
            count_dosen++;
        }

        function addMhs() {
            let newMhs = `
            <td colspan="2">
                <select class="custom-select" name="anggota_mhs[` + count_mhs + `]">
                    <option selected>Pilih Mahasiswa</option>
                    @foreach ($data['data_mhs'] as $item)
                        <option value="{{ $item->mhs_id }}">
                            ({{ $item->mhs_id }})
                            {{ $item->mhs_nama }}</option>
                    @endforeach
                </select>
            </td>
            `;
            tbMhs.innerHTML += newMhs;
            count_dosen++;
        }
    </script>
@endpush
