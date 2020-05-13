<template>
    <div class="container">
        <!--{{trans.get('success-error.insertSuccessVuePlural')}}-->
        <div class="row">
            <span class="mr-2 py-3"><i class="far fa-user-plus"></i></span>
            <input type="text" v-model="stdName" placeholder="Name and surname" class="form-control col-5 mr-1">
            <input type="email" v-model="stdEmail" placeholder="Email (optional)" class="form-control col-5 mr-1">
            <button class="btn btn-success" @click="addStudent">+ Add</button>
        </div>
       <!--<form @submit="formSubmit">
            <slot>
                <!-- CSRF gets injected into this slot -->
           <!-- </slot> 
        </form>-->
        <button v-if="students.length" class="btn btn-success mt-2 mb-1 ml-0">Create students</button>
        <div v-for="(student, index) in students" v-bind:key="student.name">
            <div class="row p-3 mt-2 bg-secondary rounded text-light relative">
                <span class="badge badge-secondary p-2 m-1 mr-2">{{ index + 1 }}</span> {{ student.name }} <i class="fal fa-at pl-2" v-if="student.email.length"></i> <span class="px-1 font-italic"> {{ student.email }}</span> <i class="fal fa-user px-2"></i> {{ student.username }} <button class="ml-2 btn btn-danger delete-button-right" v-on:click="deleteStudent(index)"><i class="far fa-trash"></i></button>
            </div>            
        </div>
    </div>
</template>

<script>
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
                //if (this.students.some('name': this.stdName == item)) return;
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
                            let toast = this.$toasted.show("<i class='fas fa-fist-raised'></i>Toasted !!", { 
                                    theme: "outline", 
                                    position: "top-center", 
                                    duration : 5000
                            });
                        });
                } else {
                }
                // else toast
            },
            sendStudents() {
                if(this.students.length) {
                    axios.post('/classrooms/students', this.students)
                        .then(response => {
                            // Toast Ok
                            let toast = this.$toasted.show("Yea !!", { 
                                theme: "outline", 
                                position: "top-center", 
                                duration : 5000
                            });
                            this.students = [];
                        });
                }
            },
            deleteStudent(index){
                this.students.splice(index, 1)
            },

            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.post('/formSubmit', {
                    name: this.name,
                    description: this.description
                })
                .then(function (response) {
                    currentObj.output = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
        }
    }
</script>
