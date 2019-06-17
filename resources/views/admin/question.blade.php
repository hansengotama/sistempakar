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
                <h4>Question</h4>
            </div>
            <div class="mt-2">
                <button class="btn btn-primary" @click="showAddModal()">
                    <i class="fa fa-plus"></i> Question
                </button>
            </div>
            <div class="mt-3">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Question Id</th>
                        <th>Question</th>
                        <th>Parent Question</th>
                        <th>Action</th>
                    </tr>
                    <tr v-for="(question, index) in questions">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ question.id }}</td>
                        <td>@{{ question.question }}</td>
                        <td>@{{ question.parent_id }}</td>
                        <td>
                            <button class="btn btn-info" @click="fillQuestion(question.id)">EDIT</button>
                            <button class="btn btn-danger" @click="validateDelete(question.id)">DELETE</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal fade" id="add-question">
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
                                <select type="text" :class="'form-control '+error.class.diseaseId" v-model="formValue.diseaseId" @change="getSelectQuestion(formValue.diseaseId)">
                                    <option v-for="disease in selectDiseases" :value=disease.id>@{{ disease.name }}</option>
                                </select>
                                <div class="red">@{{ error.text.diseaseId }}</div>
                            </div>
                            <div class="form-group">
                                <label>Question</label>
                                <input type="text" :class="'form-control '+error.class.question" v-model="formValue.question">
                                <div class="red">@{{ error.text.question }}</div>
                            </div>
                            <div class="form-group">
                                <label>Question</label>
                                <select :class="'custom-select '+ error.class.questionId" multiple v-model="formValue.questionId">
                                    <option v-for="question in selectQuestions" :value="question.id">@{{ question.question }}</option>
                                </select>
                                <small>press ctrl for select more than 1</small>
                                <div class="red">@{{ error.text.questionId }}</div>
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
        <div class="modal fade" id="edit-question">
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
                                <select type="text" :class="'form-control '+error.class.diseaseId" v-model="formValue.diseaseId" @change="getSelectQuestion(formValue.diseaseId)">
                                    <option v-for="disease in selectDiseases" :value=disease.id>@{{ disease.name }}</option>
                                </select>
                                <div class="red">@{{ error.text.diseaseId }}</div>
                            </div>
                            <div class="form-group">
                                <label>Question</label>
                                <input type="text" :class="'form-control '+error.class.question" v-model="formValue.question">
                                <div class="red">@{{ error.text.question }}</div>
                            </div>
                            <div class="form-group">
                                <label>Question</label>
                                <select :class="'custom-select '+ error.class.questionId" multiple v-model="formValue.questionId">
                                    <option v-for="question in selectQuestions" :value="question.id">@{{ question.question }}</option>
                                </select>
                                <small>press ctrl for select more than 1</small>
                                <div class="red">@{{ error.text.questionId }}</div>
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
                questions: {},
                selectedQuestionId: null,
                error: {
                    text: {
                        question: "",
                        questionId: "",
                        diseaseId: ""
                    },
                    class: {
                        question: "",
                        questionId: "",
                        diseaseId: ""
                    }
                },
                formValue: {
                    question: "",
                    questionId: [],
                    diseaseId: ""
                },
                selectDiseases: {},
                selectQuestions: [],
            },
            mounted() {
                this.getQuestions()
                this.getSelectDisease()
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
                getQuestions() {
                    axios.get("get-questions")
                    .then(function (response) {
                        if(response.status) {
                            app.questions = response.data
                        }
                    })
                },
                showAddModal() {
                    $("#add-question").modal('show')
                },
                validateForm(action) {
                    if(this.required(this.formValue.question)) {
                        this.error.text.question = "question must be required"
                        this.error.class.question = "border-red"
                    }else {
                        this.error.text.question = ""
                        this.error.class.question = ""
                    }

                    if(this.required(this.formValue.diseaseId)) {
                        this.error.text.diseaseId = "disease must be selected"
                        this.error.class.diseaseId = "border-red"
                    }else {
                        this.error.text.diseaseId = ""
                        this.error.class.diseaseId = ""
                    }

                    if(this.formValue.questionId.length == 0) {
                        this.error.text.questionId = "question must be selected at least one"
                        this.error.class.questionId = "border-red"
                    }else {
                        this.error.text.questionId = ""
                        this.error.class.questionId = ""
                    }

                    if(this.error.text.question == "" && this.error.text.questionId == "" && this.error.text.diseaseId == "") {
                        if(action == "edit") {
                            this.editQuestion()
                        }else if(action == "add") {
                            this.addQuestion()
                        }
                    }
                },
                resetForm() {
                    this.formValue.question = ""
                    this.formValue.questionId = []
                    this.formValue.diseaseId = this.selectDiseases[0].id
                    this.getSelectQuestion(this.selectDiseases[0].id)
                },
                addQuestion() {
                    axios.post("/add-question", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.resetForm()
                            app.popUpSuccess()
                            app.getQuestions()
                            $("#add-question").modal('hide')
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editQuestion() {
                    this.formValue.id = this.selectedQuestionId
                    console.log(this.formValue)
                    axios.post("/edit-question", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.resetForm()
                            app.popUpSuccess()
                            app.getQuestions()
                            $("#edit-question").modal('hide')
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getSelectDisease() {
                    axios.get("get-disease")
                    .then(function (response) {
                        if(response.status) {
                            app.selectDiseases = response.data
                            app.formValue.diseaseId = response.data[0].id
                            app.getSelectQuestion(response.data[0].id)
                        }
                    })
                },
                getSelectQuestion(disease_id) {
                    console.log(disease_id)
                    axios.get("get-question-disease/"+disease_id)
                    .then(function (response) {
                        if(response.status) {
                            app.selectQuestions = response.data
                            app.selectQuestions.push({
                                id: 0,
                                question: "begin"
                            })
                        }
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
                            this.deleteQuestion(id)
                        }
                    })
                },
                deleteQuestion(id) {
                    axios.post("delete-question", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getQuestions()
                            app.getSelectQuestion(app.selectDiseases[0].id)
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                fillQuestion(id) {
                    $("#edit-question").modal("show")

                    axios.get("get-question/"+id)
                    .then(function (response) {
                        if(response.status) {
                            app.formValue.question = response.data.question
                            app.formValue.questionId = response.data.parent_id
                            app.formValue.diseaseId = response.data.disease_id
                            app.selectedQuestionId = response.data.id
                        }
                    })
                }
            }
        });
    </script>
@endsection