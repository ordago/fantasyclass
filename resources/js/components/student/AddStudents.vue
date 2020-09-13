<template>
    <div class="has-padding-4">
        <div class="field is-horizontal">
            <form @submit.prevent="addStudent">
                <div class="field-body">
                    <div class="field is-expanded">
                    <div class="field has-addons">
                        <p class="control">
                        <a class="button is-static">
                            <i class="far fa-user-plus"></i>
                        </a>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" v-model="stdName" required type="text" minlength="4" :placeholder="trans.get('students.name_surname')">
                        </p>
                        <p class="control is-expanded">
                            <input class="input" v-model="stdEmail" type="email" :placeholder="'Email (' + trans.get('general.optional') + ')'">
                        </p>
                        <p class="control">
                            <button class="button is-primary">
                                {{ trans.get('users_groups.add_student') }}
                            </button>
                        </p>
                    </div>
                    </div>
                </div>
            </form>
        </div>
        
        
        <div v-for="(student, index) in students" v-bind:key="student.name">
            <div class=" has-margin-y-2 has-padding-4 has-background-dark has-text-light rounded text-light relative">
                <span class="has-padding-right-3">{{ index + 1 }}</span> {{ student.name }} <i class="fal fa-at pl-2" v-if="student.email.length"></i>
                 <span class="is-italic"> {{ student.email }}</span> <span class="tag is-warning has-margin-left-2" v-if="student.username.length" v-tippy content="User already exists in FantasyClass, it'll be registered in the classroom"><i class="fal fa-user pr-2"></i> {{ student.username }}</span> 
                <button class="button is-danger delete-button-right" v-on:click="deleteStudent(index)"><i class="far fa-trash"></i></button>
            </div>            
        </div>
        <button v-if="students.length" @click="sendStudents" class="button is-link">{{ trans.get('users_groups.create_students') }}</button>
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
                    Utils.toast(this, this.trans.get("validation.email"), 2)
                    return false;
                }
                let search = this.students.find(student => student.name === this.stdName);
                if(this.stdName && !search) {
                    axios.post('/classroom/students/getusername', {'name' : this.stdName, 'email' : this.stdEmail })
                        .then(response => {
                            this.stdUsername = response.data;
                            this.students.push({
                                id: this.nextId++,
                                name: this.stdName,
                                email: this.stdEmail,
                                username: this.stdUsername,
                                })
                            this.stdName = this.stdEmail = this.stdUsername = ''
                        });
                } else {
                    Utils.toast(this, this.trans.get("validation.distinct"), 2)
                }
            },
            sendStudents() {
                if(this.students.length) {
                    axios.post('/classroom/students', {
                        students: this.students,
                    })
                    .then(response => {
                        if(response.data) {
                            response.data.forEach(element => {

                                 this.$toasted.show(element, { 
                                        position: "top-right", 
                                        iconPack: 'fontawesome',
                                        type: 'error',
                                        action : {
                                            text : 'Close',
                                            onClick : (e, toastObject) => {
                                                toastObject.goAway(0);
                                            }
                                        },
                                })
                             })
                            this.students = [];
                        } else {
                            window.location = document.referrer
                        }
                    })
                    .catch( error => {
                         Utils.toast(this, error, 2)
                         this.students = []
                    });
                }
            },
            deleteStudent(index){
                this.students.splice(index, 1)
            },
        }
    }
</script>
