<template>
    <div class="container">
        <div class="row">
            <span class="mr-2 py-3"><i class="far fa-user-plus"></i></span>
            <input type="text" v-model="stdName" placeholder="Name and surname" class="form-control col-5 mr-1">
            <input type="email" v-model="stdEmail" placeholder="email" class="form-control col-5 mr-1">
            <button class="btn btn-success" @click="addStudent">+ Add</button>
        </div>
       <!--<form @submit="formSubmit">
            <slot>
                <!-- CSRF gets injected into this slot -->
           <!-- </slot> 
        </form>-->
        <div class="rounded" v-for="(student, index) in students" v-bind:key="student.id">
            <div class="row p-3 mt-2 bg-light relative">
                <span class="badge badge-secondary p-2 m-1 mr-2">{{ index + 1 }}</span> {{ student.name }} <small class="pl-1 font-italic">{{ student.email }}</small></span><button class="ml-2 btn btn-danger delete-button-right" v-on:click="deleteStudent(index)"><i class="far fa-trash"></i></button>
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
                nextId: 1,
            }
        },
        methods: {
            addStudent(){
                if(this.stdName) {
                    this.students.push({
                        id: this.nextId++,
                        name: this.stdName,
                        email: this.stdEmail,
                        });
                    this.stdName = '';
                    this.stdEmail = '';
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
