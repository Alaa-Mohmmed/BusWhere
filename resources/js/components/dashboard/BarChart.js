import {Pie} from 'vue-chartjs'


export default {
  extends: Pie,
  mounted () {
    this.renderChart({
      labels:['bus1','bus2','bus3'],
      datasets:[
      {label:'Voilation',backgroundColor:['#dd4b39','#6cb2eb','yellow'],data:[23,60,17]}
      ]
    },{responsive:true,maintainAspectRatio:false})
  }
  ,
}