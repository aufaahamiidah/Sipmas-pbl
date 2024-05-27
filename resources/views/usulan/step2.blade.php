@extends('usulan.tambah_usulan')

@section('step')
    <form @if ($_GET['edit'] != '') action="{{ url('update_step1') }}" @endif action="{{ url('step1') }}"
        method="POST">
        @csrf
        <input type="hidden" name="usulan_id" value="{{ $_GET['usulan_id'] }}">
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
                    <div class="row form-group-row p-3">
                        <div class="col-sm">
                            <label>Total Pendanaan <span style="color: red">*</span></label>
                        </div>
                        <div class="col">
                            <input type="number" name="total" class="form-control" placeholder="" required>
                            <p><b>maksimal Rp. {{ $data['max_dana'] }}</b></p>
                        </div>
                    </div>
                    <hr>
                    @foreach ($data['pendanaan'] as $key => $value)
                        <div class="row form-group-row p-3">
                            <div class="col-sm">
                                <label>{{ $value->pendanaan_nama }}<span style="color: red">*</span> (Maks. <span
                                        style="color: red">{{ $value->pendanaan_persentase }} %</span>)</label>
                            </div>
                            <div class="col">
                                <input name="{{ $value->pendanaan_id }}" type="number" class="form-control" placeholder=""
                                    required>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container mb-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('tambah_usulan?&step=1&usulan_id=' . $_GET['usulan_id'] . '') }}" type="button"
                            class="btn btn-warning"><b>Kembali</b></a>
                        <button type="submit" class="btn btn-primary"><b>Lanjutkan>></b></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
