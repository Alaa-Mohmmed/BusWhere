<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
               <div class="row">
          <div class="col-12">
                            <button class="btn btn-success col-2 rightC mt-5" style="margin-left:83%" @click="OpenModal">Add New Bus&nbsp;<i class="fas fa-user-plus"></i></button>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bus Data</h3>

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
                    <th>Bus Number</th>
                    <th>Supervisor Name</th>
                    <th>Supervisor Phone</th> 
                    <th>Modify</th>        
                  </tr>
                  <tr v-for="bus in buses" :key="bus.key" >
                    <td>{{bus.name}}</td>
                    <td>{{bus.supervisorName}}</td>
                    <td>{{bus.supervisorPhone}}</td> 
                    <td>
                    <router-link :to="`Bus/${bus.key}`">
                    <i class="fas fa-eye blue TestHover" ></i>
                    </router-link>&nbsp;/&nbsp;

                    <a href="#">
                    <i class="fas fa-edit green" @click="Editmodal(bus)"></i>
                    </a>&nbsp;/&nbsp;

                    <a href="#">
                    <i class="fas fa-trash-alt red" @click="DeleteBus(bus.key)"></i>
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
                <div class="modal fade" id="AddBus" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!EditMode" id="AddBusLabel">Add New Bus</h5>
                        <h5 class="modal-title" v-show="EditMode" id="AddBusLabel">Update Bus Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="EditMode?EditBus():CreateBus()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="busName" placeholder="Bus Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.supervisorPhone" type="text" name="supervisorPhone" placeholder="Supervisor Phone"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('supervisorPhone') }">
                                <has-error :form="form" field="supervisorPhone"></has-error>
                            </div>

                            <div class="form-group">
                                <select   v-model="form.supervisorName" name="supervisorName" placeholder="Supervisor Name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('supervisorName') }">
                                    <option value="">Select Supervisor Name</option>
                                    <option v-for="supervisor in supervisors" :value="supervisor.name">{{supervisor.name}}</option>
                                </select>
                                <has-error :form="form" field="supervisorName"></has-error>
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
              buses:{},
              supervisors:{},
              form: new Form({
                key:'',
                name:'',
                supervisorName:'',
                supervisorPhone:''
              })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            OpenModal(){
                this.form.reset();
                this.EditMode= false;
                $('#AddBus').modal('show');
            },
            LoadBuses(){
                 this.form.get('/show4').then(({ data }) => { this.buses=data })
            },
            CreateBus(){
                this.form.post('/test4')
                .then(() => { 
                    $('#AddBus').modal('hide');
                })
                .catch(()=>{

                })
                this.LoadBuses();
            },
            DeleteBus(id){
                 this.form.delete('/delete4/'+ id).then(({ }) => {this.LoadBuses(); })

            },
            EditBus(){
            this.form.put('/update4/'+ this.form.key).then(({ }) => {this.LoadBuses();
             $('#AddBus').modal('hide'); })

            },
            LoadSupervisors(){
                 this.form.get('/show2').then(({ data }) => { this.supervisors=data })
            },
            Editmodal(bus){
                this.EditMode= true;
                this.form.reset();
                $('#AddBus').modal('show');
                this.form.fill(bus);
            },
        },
        created(){
            this.LoadBuses();
            this.LoadSupervisors();
        }
    }
</script>
