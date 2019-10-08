import {Line} from 'vue-chartjs'


export default {
  extends: Line,
  data () {
            return {
            DashData:{},
            BusNames:{},
            BusCounter:{},
             form: new Form({
                
              })
            
            }
        },
  mounted () {
    this.renderChart({
      labels:['bus1','bus2','bus3'],
      datasets:[
      {label:'Voilation',backgroundColor:'#dd4b39',data:[20,40,30]}
      ]
    },{responsive:true,maintainAspectRatio:false})
  },
    methods:{
       LoadDash(){
          this.form.get('/violation').then(({ data }) => { this.DashData=data });
          // DashData.forEach((item,index,arr)=>{
          //   this.BusNames[]=arr['BusName'];
          //   this.BusCounter[]=arr['Counter'];
          // }){
          // }
       },
    },
    created(){
      this.LoadDash(); 
    }
}