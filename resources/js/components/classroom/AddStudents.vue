<template>
    <div class="container py-2">
        <!--{{trans.get('success-error.insertSuccessVuePlural')}}-->
        <div class="row">
            <span class="mr-2 py-3"><i class="far fa-user-plus"></i></span>
            <input type="text" v-model="stdName" placeholder="Name and surname" class="form-control col-5 mr-1">
            <input type="email" v-model="stdEmail" placeholder="Email (optional)" class="form-control col-5 mr-1">
            <button class="btn btn-success" @click="addStudent">+ Add</button>
        </div>
        <button v-if="students.length" @click="sendStudents" class="btn btn-success mt-2 mb-1 ml-0">Create students</button>
        <div v-for="(student, index) in students" v-bind:key="student.name">
            <div class="row p-3 mt-2 bg-secondary rounded text-light relative">
                <span class="badge badge-secondary p-2 m-1 mr-2">{{ index + 1 }}</span> {{ student.name }} <i class="fal fa-at pl-2" v-if="student.email.length"></i> <span class="px-1 font-italic"> {{ student.email }}</span> <span class="badge badge-success p-2 ml-2" v-if="student.username.length" v-tippy content="User already exists in FantasyClass, it'll be registered in the classroom"><i class="fal fa-user pr-2"></i> {{ student.username }}</span> <button class="ml-2 btn btn-danger delete-button-right" v-on:click="deleteStudent(index)"><i class="far fa-trash"></i></button>
            </div>            
        </div>
    </div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        mounted() {
        },
        data: function() {
            return {
                students: [
                ],
                stdName: '',
                stdEmail: '',
                stdUsername: '',
                nextId: 1,
            }
        },
        methods: {
            addStudent(){
                if(this.stdEmail && !Utils.validEmail(this.stdEmail)) {
                    Utils.toast(this, this.trans.get("validation.email"), 2);
                    return false;
                }
                let search = this.students.find(student => student.name === this.stdName);
                if(this.stdName && !search) {
                    axios.post('/classrooms/students/getusername', {'name' : this.stdName, 'email' : this.stdEmail })
                        .then(response => {
                            this.stdUsername = response.data;
                            this.students.push({
                                id: this.nextId++,
                                name: this.stdName,
                                email: this.stdEmail,
                                username: this.stdUsername,
                                });
                            this.stdName = this.stdEmail = this.stdUsername = '';
                        });
                } else {
                    Utils.toast(this, this.trans.get("validation.distinct"), 2);
                }
            },
            sendStudents() {
                if(this.students.length) {
                    axios.post('/classrooms/students', {
                        students: this.students,
                    })
                    .then(response => {
                        if(response.data) {
                            console.log();
                            response.data.forEach(element => {

                                 this.$toasted.show(element, { 
                                        theme: 'bubble',
                                        position: "top-center", 
                                        iconPack: 'fontawesome',
                                        action : {
                                            text : 'Close',
                                            onClick : (e, toastObject) => {
                                                toastObject.goAway(0);
                                            }
                                        },
                                });
                             });
                            this.students = [];
                        } else {
                            window.location = document.referrer;
                        }
                    })
                    .catch( error => {
                         Utils.toast(this, error, 2);
                         this.students = [];
                    });
                }
            },
            deleteStudent(index){
                this.students.splice(index, 1)
            },
        }
    }
</script>
