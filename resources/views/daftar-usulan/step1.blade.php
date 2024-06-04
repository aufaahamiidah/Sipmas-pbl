@extends('daftar-usulan.tambah_usulan')

@section('step')
    <form method="POST" @if ($_GET['usulan_id'] != '') action="update_step0"  @else action="{{ url('step_0') }}" @endif>
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
                                        @if ($_GET['usulan_id'] != '')
                                            <input type="hidden" name="usulan_id" value="{{ $_GET['usulan_id'] }}">
                                        @endif
                                        <input type="text" name="skemaid" class="form-control"
                                            @if ($_GET['usulan_id'] != '') value="{{ $data['data_usulan']['skema'][0]->trx_skema_nama }}" @endif
                                            value="{{ $data['skema_nama'] }}" disabled>
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col-12 col-lg-4">
                                        <label>Judul <b class="text-danger">*</b></label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="judul" id="judul" required
                                            @if ($_GET['usulan_id'] != '') value="{{ $data['data_usulan']['usulan'][0]->usulan_judul }}" @endif>
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col-12 col-lg-4">
                                        <label>Abstrak <b class="text-danger">*</b></label>
                                    </div>
                                    <div class="col">
                                        <textarea style="min-height: 250px;" @if ($_GET['usulan_id'] != '')  @endif class="form-control" id="abstrak"
                                            name="abstrak" required>
@if ($_GET['usulan_id'] != '')
{{ $data['data_usulan']['usulan'][0]->usulan_abstrak }}
@endif
</textarea>
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
                                            <td></td>
                                            <td>
                                                <select class="custom-select" name="ketua_dosen" disabled>
                                                    <option selected value="{{ $data['ketua_dosen'][0]->dosen_id }}">
                                                        {{ $data['ketua_dosen'][0]->dosen_nama_lengkap }}
                                                        <b>(*Ketua)</b>
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                        @if ($_GET['usulan_id'] != '')
                                            @foreach ($data['data_usulan']['anggota_dosen'] as $key => $value)
                                                <tr>
                                                    <td class="text-center col-2">
                                                        <button type="button" class="btn btn-danger delete-row"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td>
                                                        <select class="custom-select" name="anggota_dosen[]">
                                                            <option selected value="{{ $value->dosen_id }}">
                                                                {{ $value->dosen_nama_lengkap }}
                                                            </option>
                                                            @foreach ($data['data_dosen'] as $item)
                                                                <option value="{{ $item->dosen_id }}">
                                                                    ({{ $item->dosen_id }})
                                                                    {{ $item->dosen_nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center col-2">
                                                    <button class="btn btn-danger delete-row"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                                <td>
                                                    <select class="custom-select" name="anggota_dosen[0]">
                                                        <option selected>Pilih Dosen</option>
                                                        @foreach ($data['data_dosen'] as $item)
                                                            <option value="{{ $item->dosen_id }}">
                                                                ({{ $item->dosen_id }})
                                                                {{ $item->dosen_nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div>

                                <table class="table table-bordered" id="tableMhs">
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
                                        @if ($_GET['usulan_id'] != '')
                                            @foreach ($data['data_usulan']['anggota_mhs'] as $key => $value)
                                                <tr>
                                                    <td class="text-center col-2">
                                                        <button class="btn btn-danger delete-row"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                    <td>
                                                        <select class="custom-select" name="anggota_mhs[]">
                                                            <option selected value="{{ $value->mhs_id }}">
                                                                {{ $value->mhs_nama }}
                                                            </option>
                                                            @foreach ($data['data_mhs'] as $item)
                                                                <option value="{{ $item->mhs_id }}">
                                                                    ({{ $item->mhs_id }})
                                                                    {{ $item->mhs_nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center col-2">
                                                    <button class="btn btn-danger delete-row"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                                <td>
                                                    <select class="custom-select" name="anggota_mhs[0]">
                                                        <option selected>Pilih Mahasiswa</option>
                                                        @foreach ($data['data_mhs'] as $item)
                                                            <option value="{{ $item->mhs_id }}">
                                                                ({{ $item->mhs_id }})
                                                                {{ $item->mhs_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endif
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
        // Delete row on delete button click
        $(document).on("click", ".delete", function() {
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });

        const tbDosen = document.getElementById('isiDosen');
        const tbMhs = document.getElementById('isiMhs');

        function addDosen() {
            let newDosen = `
            <td class="text-center col-2">
                <button class="btn btn-danger delete-row" type="button"><i class="fas fa-trash"></i></button>
            </td>
            <td colspan="2">
                <select class="custom-select" name="anggota_dosen[]">
                    <option selected>Pilih Dosen</option>
                    @foreach ($data['data_dosen'] as $item)
                        <option value="{{ $item->dosen_id }}">
                            ({{ $item->dosen_id }})
                            {{ $item->dosen_nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </td>
            `;
            tbDosen.innerHTML += newDosen;
        }

        function addMhs() {
            let newMhs = `
            <td class="text-center col-2">
                <button class="btn btn-danger delete-row" type="button"><i class="fas fa-trash"></i></button>
            </td>
            <td>
                <select class="custom-select" name="anggota_mhs[]">
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
        }

        var tabelDosen = document.getElementById('tableDosen');
        var tabelMhs = document.getElementById('tableMhs');

        tabelDosen.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
                const rows = document.querySelectorAll('#tableDosen tbody tr');
                rows.forEach((row, index) => {
                    row.querySelector('th').textContent = index + 1;
                });
            }
        });

        tabelMhs.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
                const rows = document.querySelectorAll('#tableMhs tbody tr');
                rows.forEach((row, index) => {
                    row.querySelector('th').textContent = index + 1;
                });
            }
        });
    </script>
@endpush
