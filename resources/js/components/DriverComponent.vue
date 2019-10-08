<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
               <div class="row">
          <div class="col-12">
                            <button class="btn btn-success col-2 rightC mt-5" style="margin-left:83%" @click="OpenModal">Add New Driver&nbsp;<i class="fas fa-user-plus"></i></button>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Driver Data</h3>

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
                    <th>Name</th>
                    <th>Phone</th> 
                    <th>Modify</th>        
                  </tr>
                  <tr v-for="driver in drivers" :key="driver.key" >
                    <td>{{driver.busName}}</td>
                    <td>{{driver.name}}</td>
                    <td>{{driver.phone}}</td> 
                    <td>
                    <a href="#">
                    <i class="fas fa-edit green" @click="Editmodal(driver)"></i>
                    </a>&nbsp;/&nbsp;

                    <a href="#">
                    <i class="fas fa-trash-alt red" @click="DeleteDriver(driver.key)"></i>
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
                <div class="modal fade" id="AddDriver" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!EditMode" id="AddDriverLabel">Add New Driver</h5>
                        <h5 class="modal-title" v-show="EditMode" id="AddDriverLabel">Update Driver Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="EditMode?EditDriver():CreateDriver()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Driver Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <select v-model="form.busName" name="busName" placeholder="Bus Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('busName') }">
                                    <option value="" disabled>Select Driver Bus</option>
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

              drivers:{},
               buses:{},
           
              form: new Form({
                key:'',
                busName:'',
                name:'',
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
                $('#AddDriver').modal('show');
            },
            LoadDrivers(){
                 this.form.get('/show3').then(({ data }) => { this.drivers=data })
            },
            CreateDriver(){
                this.form.post('/test3')
                .then(() => { 
                    $('#AddDriver').modal('hide');
                })
                .catch(()=>{

                })
                this.LoadDrivers();
            },
            LoadBuses(){
                 this.form.get('/show4').then(({ data }) => { this.buses=data })
            },
            DeleteDriver(id){
                 this.form.delete('/delete3/'+ id).then(({ }) => {this.LoadDrivers(); })

            },
            EditDriver(){
            this.form.put('/update3/'+ this.form.key).then(({ }) => {this.LoadDrivers();
             $('#AddDriver').modal('hide'); })

            },
            Editmodal(driver){
                this.EditMode= true;
                this.form.reset();
                $('#AddDriver').modal('show');
                this.form.fill(driver);
            },
        },
        created(){
            this.LoadDrivers();
            this.LoadBuses();
        }
    }
</script>
