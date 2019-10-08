import {Line} from 'vue-chartjs'


export default {
  extends: Line,
  mounted () {
    this.renderChart({
      labels:['bus1','bus2','bus3'],
      datasets:[
      {label:'Voilation',backdropColor:'#000',data:[10,20,30]}
      ]
    },{responsive:true,maintainAspectRatio:false})
  }
  ,
}