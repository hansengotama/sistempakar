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
                <h4>Disease</h4>
            </div>
            <div class="mt-2">
                <button class="btn btn-primary" @click="showAddModal()">
                    <i class="fa fa-plus"></i> Disease
                </button>
            </div>
            <div class="mt-3">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    <tr v-for="(disease, index) in diseases">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ disease.name }}</td>
                        <td>
                            <button class="btn btn-info" @click="fillDisease(disease.id)">EDIT</button>
                            <button class="btn btn-danger" @click="validateDelete(disease.id)">DELETE</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal fade" id="edit-disease">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Disease</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" :class="'form-control '+error.class.name" v-model="formValue.name">
                                <div class="red">@{{ error.text.name }}</div>
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
        <div class="modal fade" id="add-disease">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Disease</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" :class="'form-control '+error.class.name" v-model="formValue.name">
                                <div class="red">@{{ error.text.name }}</div>
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
                    name: ""
                },
                error: {
                    class: {
                        name: ""
                    },
                    text: {
                        name: ""
                    }
                },
                diseases: {},
                selectedDiseaseId: null
            },
            mounted() {
                this.getDiseases()
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
                    if(this.required(this.formValue.name)) {
                        this.error.class.name = "border-red"
                        this.error.text.name = "name must be required"
                    }else {
                        this.error.class.name = ""
                        this.error.text.name = ""
                    }

                    if(this.error.class.name == "") {
                        if(action == "edit") {
                            this.editDisease()
                        }else if(action == "add") {
                            this.addDisease()
                        }
                    }
                },
                getDiseases() {
                    axios.get("get-disease")
                    .then(function (response) {
                        if(response.status) {
                            app.diseases = response.data
                        }
                    })
                },
                resetForm() {
                    this.formValue.name = ""
                },
                showAddModal() {
                    $("#add-disease").modal("show")
                },
                addDisease() {
                    axios.post("add-disease", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.resetForm()
                            app.popUpSuccess()
                            app.getDiseases()
                            $("#add-disease").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editDisease() {
                    this.formValue.id = this.selectedDiseaseId

                    axios.post("edit-disease", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.resetForm()
                            app.popUpSuccess()
                            app.getDiseases()
                            $("#edit-disease").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                deleteDisease(id) {
                    axios.post("delete-disease", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getDiseases()
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
                            this.deleteDisease(id)
                        }
                    })
                },
                fillDisease(id) {
                    $("#edit-disease").modal("show")

                    axios.get("get-disease/"+id)
                    .then(function (response) {
                        if (response.status) {
                            app.formValue.name = response.data.name
                            app.selectedDiseaseId = response.data.id
                        }
                    })
                }
            }
        });
    </script>
@endsection