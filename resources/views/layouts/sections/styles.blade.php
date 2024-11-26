<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Doto:wght,ROND@900,100&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/materialdesignicons.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/flag-icons.css')) }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css' .$configData['rtlSupport'] .'/core.css')) }}" class="{{ $configData['hasCustomizer'] ? 'template-customizer-core-css' : '' }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css' .$configData['rtlSupport'] .'/' .$configData['theme'].'.css')) }}" class="{{ $configData['hasCustomizer'] ? 'template-customizer-theme-css' : '' }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />

<!-- Vendor Styles -->
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/node-waves/node-waves.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/typeahead-js/typeahead.css')) }}" />

{{-- Sweetalert --}}
<link rel="stylesheet" href="assets/vendor/libs/animate-css/animate.css" />
<link rel="stylesheet" href="assets/vendor/libs/sweetalert2/sweetalert2.css" />


{{-- Custome --}}
<link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/brutalism.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">





@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')
