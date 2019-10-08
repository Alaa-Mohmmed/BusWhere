<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
               <div class="row">
          <div class="col-12">
                            <button class="btn btn-success col-2 rightC mt-5" style="margin-left:83%" @click="OpenModal">Add New Station&nbsp;<i class="fas fa-user-plus"></i></button>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Station Data</h3>

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
                    <th>Student Name</th>
                    <th> Student Phone</th> 
                    <th>Modify</th>        
                  </tr>
                  <tr v-for="station in stations" :key="station.key" >
                    <td>{{station.studentName}}</td>
                    <td>{{station.studentPhone}}</td> 
                    <td>
                    <a href="#">
                    <i class="fas fa-edit green" @click="Editmodal(station)"></i>
                    </a>&nbsp;/&nbsp;

                    <a href="#">
                    <i class="fas fa-trash-alt red" @click="DeleteStation(station.key)"></i>
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
                <div class="modal fade" id="AddStation" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!EditMode" id="AddStationLabel">Add New Station</h5>
                        <h5 class="modal-title" v-show="EditMode" id="AddStationLabel">Update Station Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="EditMode?EditStation():CreateStation()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.studentName" type="text" name="name" placeholder="Station Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.studentPhone" type="text" name="phone" placeholder="Phone Number"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
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
                stationID:0,
              EditMode:false,

              stations:{},

           
              form: new Form({
                key:'',
                studentName:'',
                studentPhone:''
              })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            OpenModal(){
                this.form.reset();
                $('#AddStation').modal('show');
            },
            LoadStations(){
                 this.form.get('/show5/'+ this.stationID).then(({ data }) => { this.stations=data })
            },
            CreateStation(){
                this.form.post('/test5/'+this.stationID)
                .then(() => { 
                    $('#AddStation').modal('hide');
                })
                .catch(()=>{

                })
                this.LoadStations();
            },
            
            DeleteStation(id){
                 this.form.delete('/delete5/'+this.stationID+'/'+ id).then(({ }) => {this.LoadStations(); })

            },
            EditStation(){
            this.form.put('/update5/'+this.stationID+'/'+ this.form.key).then(({ }) => {this.LoadStations();
             $('#AddStation').modal('hide'); })

            },
            Editmodal(station){
                this.EditMode= true;
                this.form.reset();
                $('#AddStation').modal('show');
                this.form.fill(station);
            },
        },
        created(){
            this.stationID=this.$route.params.stationID;
            this.LoadStations();
        }
    }
</script>
