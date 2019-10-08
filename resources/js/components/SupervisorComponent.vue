<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
               <div class="row">
          <div class="col-12">
                             <button class="btn btn-success col-2 rightC mt-5" style="margin-left:83%" @click="OpenModal">Add New Supervisor&nbsp;<i class="fas fa-user-plus"></i></button>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Supervisor Data</h3>

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
                    <th>Bus Number</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="supervisor in supervisors" :key="supervisor.key" >
                    <td>{{supervisor.name}}</td>
                    <td>{{supervisor.email}}</td>
                    <td>{{supervisor.phone}}</td>
                    <td>{{supervisor.busName}}</td>
                    <td>
                    <a href="#">
                    <i class="fas fa-edit green" @click="Editmodal(supervisor)"></i>
                    </a>&nbsp;/&nbsp;

                    <a href="#">
                    <i class="fas fa-trash-alt red" @click="DeleteSupervisor(supervisor.key)"></i>
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
                <div class="modal fade" id="AddSupervisor" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!EditMode" id="AddSupervisorLabel">Add New Supervisor</h5>
                        <h5 class="modal-title" v-show="EditMode" id="AddSupervisorLabel">Update Supervisor Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="EditMode?EditSupervisor():CreateSupervisor()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Supervisor Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
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
                                <select v-model="form.busName" name="busName" placeholder="Bus Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('busName') }">
                                    <option value="" disabled>Select Supervisor Bus</option>
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
              supervisors:{},
              buses:{},
              form: new Form({
                key:'',
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
                $('#AddSupervisor').modal('show');
            },
            LoadSupervisors(){
                 this.form.get('/show2').then(({ data }) => { this.supervisors=data })
            },
            LoadBuses(){
                 this.form.get('/show4').then(({ data }) => { this.buses=data })
            },
            CreateSupervisor(){
                this.form.post('/test2')
                .then(() => { 
                    $('#AddSupervisor').modal('hide');
                })
                .catch(()=>{

                })
                this.LoadSupervisors();
            },
            DeleteSupervisor(id){
                 this.form.delete('/delete2/'+ id).then(({ }) => {this.LoadSupervisors(); })

            },
            EditSupervisor(){
            this.form.put('/update2/'+ this.form.key).then(({ }) => {this.LoadSupervisors();
             $('#AddSupervisor').modal('hide'); })

            },
            Editmodal(supervisor){
                this.EditMode= true;
                this.form.reset();
                $('#AddSupervisor').modal('show');
                this.form.fill(supervisor);
            },
        },
        created(){
            this.LoadSupervisors();
            this.LoadBuses();
        }
    }
</script>
