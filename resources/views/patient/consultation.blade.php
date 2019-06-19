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
    <div class="container" style="text-align: center">
        <div v-if="!finish">
            <div class="mt-5">
                <h3><b>Question @{{ totalQuestion }}</b></h3>
            </div>
            <div class="mt-5">
                <div><h1>@{{ question.question }}</h1></div>
            </div>
            <div class="answer-container mt-3">
                <button class="btn btn-info"
                        style="font-size: 50px; padding: 0 69px"
                        @click="answerTrue()">
                    <i class="fa fa-check"></i>
                </button>
                <button class="btn btn-info ml-3"
                        style="font-size: 50px; padding: 0 79px"
                        @click="answerFalse()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div v-else>
            <div class="mt-5">
                <h3>Sistem menunjukan penyakit yang anda derita adalah <b>@{{ disease.name }}</b></h3>
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
                questions: [],
                question: "",
                readyQuestions: [],
                totalQuestion: 1,
                answers: [],
                checkQuestion: false,
                finish: false,
                diseases: [],
                disease: {}
            },
            mounted() {
                this.getAllQuestion()
                this.getAllDiseases()
            },
            methods: {
                inArrayOfObject(key, value, array) {
                    let response = false

                    for (var i = 0; i < array.length; i++) {
                        if (array[i][key] == value)
                            response = array[i]
                    }

                    return response
                },
                removeObjectInArray(array, index) {
                    array.splice(index, 1)
                },
                getAllQuestion() {
                    axios.get("/get-all-questions")
                    .then(function (response) {
                        if(response.status) {
                            app.questions = response.data
                            app.getReadyQuestion()
                        }
                    })
                },
                getReadyQuestion() {
                    this.checkQuestion = false

                    for(let i = 0; i < this.questions.length; i++) {
                        if(this.questions[i].parent_id == null || this.questions[i].parent_id.length == 0) {
                            this.readyQuestions.push(this.questions[i])
                            this.removeObjectInArray(this.questions, i)
                            this.checkQuestion = true
                        }
                    }

                    if (this.checkQuestion)
                        this.getQuestion()
                    else {
                        this.finish = true

                        let answersTrue = []
                        let index = 0
                        for(let i = 0; i < this.answers.length; i++) {
                            if(this.answers[i].answer) {
                                answersTrue[index] = this.answers[i]
                                index++
                            }
                        }

                        let res = answersTrue.reduce(function(obj, v) {
                            obj[v.disease_id] = (obj[v.disease_id] || 0) + 1

                            return obj;
                        }, {})
                        let value = this.getMaxOfArray(Object.values(res))
                        let disease_id = this.getKeyByValue(res, value)

                        this.disease = this.inArrayOfObject("id", disease_id, this.diseases)

                        let answers = {
                            answers : this.answers,
                            disease_id : disease_id
                        }
                        axios.post("/add-session-answer", answers)
                    }
                },
                getMaxOfArray(numArray) {
                    return Math.max.apply(null, numArray);
                },
                getKeyByValue(object, value) {
                    return Object.keys(object).find(key => object[key] === value);
                },
                getAllDiseases() {
                    axios.get("/get-all-diseases-patient")
                    .then(function (response) {
                        if(response.status) {
                            app.diseases = response.data
                        }
                    })
                },
                getQuestion() {
                    if(this.readyQuestions.length > 0) {
                        this.question = this.readyQuestions[0]
                        this.removeObjectInArray(this.readyQuestions, 0)
                    }else {
                        this.question = ""
                        this.getReadyQuestion()
                    }
                },
                answerTrue() {
                    this.totalQuestion++
                    this.answers.push({
                        question_id: this.question.id,
                        answer: true,
                        disease_id: this.question.disease_id
                    })

                    for(let i=0; i<this.questions.length; i++) {
                        if(this.questions[i].parent_id) {
                            let index = this.questions[i].parent_id.indexOf(this.question.id)

                            if(index != -1)
                                this.questions[i].parent_id.splice(index, 1)
                        }
                    }

                    this.getQuestion()
                },
                answerFalse() {
                    this.totalQuestion++
                    this.answers.push({
                        question_id: this.question.id,
                        answer: false,
                        disease_id: this.question.disease_id
                    })

                    this.getQuestion()
                }
            }
        })
    </script>
@endsection