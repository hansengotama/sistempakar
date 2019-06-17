@extends('layouts.app')

@section('style')
    <style>
        .login-text {
            margin-bottom: 1em;
            font-size: 24px;
        }
        .form-container {
            margin: 0 3em;
        }
    </style>
@endsection

@section('content')
<section>
    <div class="container">

    </div>
</section>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                question: ""
            },
        })
    </script>
@endsection