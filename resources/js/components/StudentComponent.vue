<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
               <div class="row">
          <div class="col-12">
                            <button class="btn btn-success col-2 rightC mt-5" style="margin-left:83%"  @click="OpenModal">Add New Student&nbsp;<i class="fas fa-user-plus"></i></button>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student Data</h3>

                <div class="card-tools">
                            <form>
                            
                        
                    <div class="input-group input-group-sm ml-5" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Bus Number</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="student in students" :key="student.key" >
                    <td>{{student.name}}</td>
                    <td>{{student.email}}</td>
                    <td>{{student.phone}}</td>
                    <td>{{student.address}}</td>
                    <td>{{student.busName}}</td>
                    <td>
                    <a href="#">
                    <i class="fas fa-edit green" @click="Editmodal(student)"></i>
                    </a>&nbsp;/&nbsp;

                    <a href="#">
                    <i class="fas fa-trash-alt red"@click="DeleteStudent(student.key)" ></i>
                    </a>
                    </td> 
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
            </div>
        </div>
                <div class="modal fade" id="AddStudent" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!EditMode" id="AddStudentLabel">Add New Student</h5>
                        <h5 class="modal-title" v-show="EditMode" id="AddStudentLabel">Update Student Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="EditMode?EditStudent():CreateStudent()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Student Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.email" type="text" name="email" placeholder="Email Address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.address" type="text" name="address" placeholder="Address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                                <has-error :form="form" field="address"></has-error>
                            </div>

                            <div class="form-group">
                                <select v-model="form.busName" name="busName" placeholder="Bus Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('busName') }">
                                    <option value="" disabled>Select Student Bus</option>
                                    <option v-for="bus in buses" :value="bus.name">{{bus.name}}</option>
                                </select>
                                <has-error :form="form" field="name"></has-error>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" v-show="!EditMode" class="btn btn-primary">Create</button>
                            <button type="submit" v-show="EditMode" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
            EditMode:false,
              students:{},
              buses:{},
              form: new Form({
                key:'',
                address:'',
                busName:'',
                name:'',
                email:'',
                phone:''
              })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            OpenModal(){
                this.form.reset();
                $('#AddStudent').modal('show');
            },
            LoadStudents(){
                 this.form.get('/show').then(({ data }) => { this.students=data })
            },
            LoadBuses(){
                 this.form.get('/show4').then(({ data }) => { this.buses=data })
            },
            CreateStudent(){
                this.form.post('/test')
                .then(() => { 
                    $('#AddStudent').modal('hide');
                })
                .catch(()=>{

                })
                this.LoadStudents();
            },
            DeleteStudent(id){
                 this.form.delete('/delete/'+ id).then(({ }) => {this.LoadStudents(); })

            },
            EditStudent(){
            this.form.put('/update/'+ this.form.key).then(({ }) => {this.LoadStudents();
             $('#AddStudent').modal('hide'); })

            },
            Editmodal(student){
                this.EditMode= true;
                this.form.reset();
                $('#AddStudent').modal('show');
                this.form.fill(student);
            },
        },
        created(){
            this.LoadStudents();
            this.LoadBuses();
        }
    }
</script>
