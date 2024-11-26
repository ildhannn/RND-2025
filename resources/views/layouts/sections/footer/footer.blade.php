@php
    $containerFooter = $configData['contentLayout'] === 'compact' ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="mb-2 mb-md-0 brutal-footer">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>,
                Dibuat oleh <a href="{{ !empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '' }}"
                    target="_blank"
                    class="footer-link fw-medium">{{ !empty(config('variables.creatorName')) ? config('variables.creatorName') : '' }}, </a>
                <span class="footer-text" id="footer-text"></span>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->

@section('page-footer-script')
    <script>
        $(window).on('load', function() {
            let url = "{{ route('fetch-logo_headerFavaico') }}";

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    $('#footer-text').append(data.footer);
                });
        });
    </script>
@endsection
