@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Face Recognation')

@section('content')

    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pengaturan Recognation</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('post-pengaturan-fr') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-merge mb-4">
                                <span id="basic-icon-default-threshold" class="input-group-text"><i
                                        class="mdi mdi-apps"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="threshold"
                                        aria-describedby="basic-icon-default-threshold" name="threshold" />
                                    <label for="basic-icon-default-threshold">Akurasi</label>
                                </div>
                            </div>
                            <div class="form-text">Tingkat Akurasi Wajah (0.1 - 0.9)</div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-page-layout-footer"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="prediction" class="form-control"
                                            aria-describedby="basic-icon-default-prediction" name="prediction" />
                                        <label for="basic-icon-default-prediction">Prediksi</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Tingkat Prediksi Wajah (1 - 9)</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-settingFR-script')

    <script>
        // get setting json
        $(document).ready(function() {
            const path = '{{ url('setting_fr') }}';
            fetch(path)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Terjadi kesalahan' + res.statusText);
                    }
                    return res.json();
                })
                .then(data => {
                    let setting = data[0];
                    document.getElementById('threshold').value = setting.threshold;
                    document.getElementById('prediction').value = setting.prediction;

                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    </script>

@endsection
