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
                <h4>Disease Solution</h4>
            </div>
            <div class="mt-2">
                <button class="btn btn-primary" @click="showAddModal()">
                    <i class="fa fa-plus"></i> Disease Question
                </button>
            </div>
            <div class="mt-3">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Disease</th>
                        <th>Solution</th>
                        <th>Action</th>
                    </tr>
                    <tr v-for="(diseaseSolution, index) in diseaseSolutions">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ diseaseSolution.disease.name }}</td>
                        <td>@{{ diseaseSolution.solution.context }}</td>
                        <td>
                            <button class="btn btn-info" @click="fillDiseaseSolution(diseaseSolution.id)">EDIT</button>
                            <button class="btn btn-danger" @click="validateDiseaseSolution(diseaseSolution.id)">DELETE</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal fade" id="add-disease-solution">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Disease</label>
                                <select type="text" :class="'form-control '+error.class.diseaseId" v-model="formValue.diseaseId">
                                    <option v-for="disease in selectDiseases" :value=disease.id>@{{ disease.name }}</option>
                                </select>
                                <div class="red">@{{ error.text.diseaseId }}</div>
                            </div>
                            <div class="form-group">
                                <label>Solution</label>
                                <select type="text" :class="'form-control '+error.class.solutionId" v-model="formValue.solutionId">
                                    <option v-for="solution in selectSolutions" :value=solution.id>@{{ solution.context }}</option>
                                </select>
                                <div class="red">@{{ error.text.solutionId }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateForm('add')">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-disease-solution">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Disease</label>
                                <select type="text" :class="'form-control '+error.class.diseaseId" v-model="formValue.diseaseId">
                                    <option v-for="disease in selectDiseases" :value=disease.id>@{{ disease.name }}</option>
                                </select>
                                <div class="red">@{{ error.text.diseaseId }}</div>
                            </div>
                            <div class="form-group">
                                <label>Solution</label>
                                <select type="text" :class="'form-control '+error.class.solutionId" v-model="formValue.solutionId">
                                    <option v-for="solution in selectSolutions" :value=solution.id>@{{ solution.context }}</option>
                                </select>
                                <div class="red">@{{ error.text.solutionId }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateForm('edit')">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                formValue: {
                    diseaseId: "",
                    solutionId: ""
                },
                error: {
                    text: {
                        diseaseId: "",
                        solutionId: ""
                    },
                    class: {
                        diseaseId: "",
                        solutionId: ""
                    }
                },
                diseaseSolutions: {},
                selectDiseases: {},
                selectSolutions: {},
                selectedDiseaseSolution: null
            },
            mounted() {
                this.getDiseaseSolutions()
                this.getSelectDiseases()
                this.getSelectSolutions()
            },
            methods: {
                popUpError() {
                    swal({
                        heightAuto: true,
                        type: 'error',
                        title: 'Error!',
                    })
                },
                popUpSuccess() {
                    swal({
                        heightAuto: true,
                        type: 'success',
                        title: 'Success!',
                    })
                },
                showAddModal() {
                    $("#add-disease-solution").modal("show")
                },
                getDiseaseSolutions() {
                    axios.get("/get-disease-solutions")
                    .then(function (response) {
                        if(response.status) {
                            app.diseaseSolutions = response.data
                        }
                    })
                },
                getSelectDiseases() {
                    axios.get("/get-disease")
                    .then(function (response) {
                        if(response.status) {
                            app.selectDiseases = response.data
                            app.formValue.diseaseId = response.data[0].id
                        }
                    })
                },
                getSelectSolutions() {
                    axios.get("/get-solutions")
                    .then(function (response) {
                        if(response.status) {
                            app.selectSolutions = response.data
                            app.formValue.solutionId = response.data[0].id
                        }
                    })
                },
                validateForm(action) {
                    if(action == "edit") {
                        this.editDiseaseSolution()
                    }else if(action == "add") {
                        this.addDiseaseSolution()
                    }
                },
                addDiseaseSolution() {
                    axios.post("/add-disease-solution", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            $("#add-disease-solution").modal("hide")
                            app.getDiseaseSolutions()
                            app.popUpSuccess()
                            app.resetForm()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editDiseaseSolution() {
                    this.formValue.id = this.selectedDiseaseSolution

                    axios.post("/edit-disease-solution", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            $("#edit-disease-solution").modal("hide")
                            app.getDiseaseSolutions()
                            app.popUpSuccess()
                            app.resetForm()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                resetForm() {
                    this.formValue.diseaseId = app.selectDiseases[0].id
                    this.formValue.solutionId = app.selectSolutions[0].id
                },
                validateDiseaseSolution(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.deleteDiseaseSolution(id)
                        }
                    })
                },
                deleteDiseaseSolution(id) {
                    axios.post("/delete-disease-solution", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.getDiseaseSolutions()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                fillDiseaseSolution(id) {
                    $("#edit-disease-solution").modal("show")

                    axios.get("get-disease-solution/"+id)
                    .then(function (response) {
                        if(response.status) {
                            app.formValue.solutionId = response.data.solution_id
                            app.formValue.diseaseId = response.data.disease_id
                            app.selectedDiseaseSolution = response.data.id
                        }
                    })
                }
            }
        });
    </script>
@endsection