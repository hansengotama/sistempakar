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
    <section style="padding: 0 65px ">
        <table class="table mt-5">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Disease</th>
                <th>Disease Solution</th>
                <th>Answers</th>
                <th>Created At</th>
            </tr>
            <tr v-for="(consultationDetail, index) in consultationDetails">
                <td>@{{ index+1 }}</td>
                <td>@{{ consultationDetail.user.name }}</td>
                <td>@{{ consultationDetail.disease.name }}</td>
                <td>
                    <span v-for="(disease_solution, index) in consultationDetail.disease_solutions">
                        <p>@{{ index+1 }}. @{{ disease_solution.solution.context }}</p>
                    </span>
                </td>
                <td>
                    <span v-for="(answer, index) in consultationDetail.answers">
                        <p>@{{ index+1 }}. @{{ answer.question.question }} :
                            <span v-if="answer.answer==1" style="color: green"><b>true</b></span>
                            <span v-if="answer.answer==0" style="color: red"><b>false</b></span>
                        </p>
                    </span>
                </td>
                <td>@{{ consultationDetail.created_at }}</td>
            </tr>
        </table>
    </section>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                consultationDetails: {}
            },
            mounted() {
                this.getConsultationDetail()
            },
            methods: {
                getConsultationDetail() {
                    axios.get("/get-consultation-detail")
                    .then(function (response) {
                        if(response.status) {
                            app.consultationDetails = response.data
                            console.log(app.consultationDetails)
                        }
                    })
                }
            }
        });
    </script>
@endsection