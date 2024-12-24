@php
    $width = $width ?? '25';
    $withbg = $withbg ?? '#666cff';
@endphp
{{-- <div class="cirle" style="border: 2px dotted #626262; border-radius: 50%;"> --}}
<div class="cirle">
    <img src="" alt="ico" width="50" id="logo_header" height="50">
</div>
<span class="app-brand-text demo menu-text fw-bold mt-3">
    <h1 id="app-brand-text"></h1>
</span>
{{-- <span class="app-brand-text demo menu-text fw-bold" id="app-brand-text"></span> --}}
@section('page-script')
    <script>
        $(window).on('load', function() {
            let url = "{{ route('fetch-logo_headerFavaico') }}";

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    $('#logo_header').attr('src', data.url_logo_header);
                    $('#app-brand-text').text(data.nama_apk);
                });
        });
    </script>
@endsection
