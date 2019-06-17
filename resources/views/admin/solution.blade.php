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
                <h4>Solution</h4>
            </div>
            <div class="mt-2">
                <button class="btn btn-primary" @click="showAddModal()">
                    <i class="fa fa-plus"></i> Solution
                </button>
            </div>
            <div class="mt-3">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Context</th>
                        <th>Action</th>
                    </tr>
                    <tr v-for="(solution, index) in solutions">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ solution.context }}</td>
                        <td>
                            <button class="btn btn-info" @click="fillSolution(solution.id)">EDIT</button>
                            <button class="btn btn-danger" @click="validateDelete(solution.id)">DELETE</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal fade" id="edit-solution">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Solution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Context</label>
                                <input type="text" :class="'form-control '+error.class.context" v-model="formValue.context">
                                <div class="red">@{{ error.text.context }}</div>
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
        <div class="modal fade" id="add-solution">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Solution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Context</label>
                                <input type="text" :class="'form-control '+error.class.context" v-model="formValue.context">
                                <div class="red">@{{ error.text.context }}</div>
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
    </section>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                formValue: {
                    context: ""
                },
                error: {
                    class: {
                        context: ""
                    },
                    text: {
                        context: ""
                    }
                },
                solutions: {},
                selectedSolutionId: null
            },
            mounted() {
                this.getSolutions()
            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
                },
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
                validateForm(action) {
                    if(this.required(this.formValue.context)) {
                        this.error.class.context = "border-red"
                        this.error.text.context = "context must be required"
                    }else {
                        this.error.class.context = ""
                        this.error.text.context = ""
                    }

                    if(this.error.class.context == "") {
                        if(action == "edit") {
                            this.editSolution()
                        }else if(action == "add") {
                            this.addSolution()
                        }
                    }
                },
                getSolutions() {
                    axios.get("get-solutions")
                    .then(function (response) {
                        if(response.status) {
                            app.solutions = response.data
                        }
                    })
                },
                resetForm() {
                    this.formValue.context = ""
                },
                showAddModal() {
                    $("#add-solution").modal("show")
                },
                addSolution() {
                    axios.post("add-solution", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.resetForm()
                            app.popUpSuccess()
                            app.getSolutions()
                            $("#add-solution").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editSolution() {
                    this.formValue.id = this.selectedSolutionId

                    axios.post("edit-solution", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.resetForm()
                            app.popUpSuccess()
                            app.getSolutions()
                            $("#edit-solution").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                deleteSolution(id) {
                    axios.post("delete-solution", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getSolutions()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                validateDelete(id) {
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
                            this.deleteSolution(id)
                        }
                    })
                },
                fillSolution(id) {
                    $("#edit-solution").modal("show")

                    axios.get("get-solution/"+id)
                    .then(function (response) {
                        if (response.status) {
                            app.formValue.context = response.data.context
                            app.selectedSolutionId = response.data.id
                        }
                    })
                }
            }
        });
    </script>
@endsection