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
        .border-red {
            border-color: #ff0024;
        }
        .red {
            color: #ff0024;
        }
    </style>
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="mt-4">
                <h4>List Patient</h4>
            </div>
            <div class="mt-3">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                    </tr>
                    <tr v-for="(patient, index) in patients">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ patient.username }}</td>
                        <td>@{{ patient.name }}</td>
                        <td>@{{ patient.age }}</td>
                        <td>@{{ patient.gender }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                patients: {}
            },
            mounted() {
                this.getPatients()
            },
            methods: {
                getPatients() {
                    axios.get("get-list-patients")
                    .then(function (response) {
                        if(response.status) {
                            app.patients = response.data
                        }
                    })
                }
            }
        });
    </script>
@endsection