@extends('layouts/layoutMaster')

@section('title', 'Sandbox')

@section('head')
    <div class="brutal-header">
        <p class="text-light">SANDBOX</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div id="table-user"></div>
    </div>
@endsection

@section('page-sandbox-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let data = @json($user['users']);
            let total = Number("{{ $user['total'] }}");
            initUserTable('table-user', data, total);
        });
    </script>
@endsection
