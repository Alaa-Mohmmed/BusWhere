<template>

  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
               <div class="row">
                    <div class="col-12">

                           <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>150</h3>

                <p>Trips</p>
              </div>
              <div class="icon">
                <i class="fas fa-bus-alt"></i>
              </div>
              <a href="#" class="small-box-footer">
               Number of Trips
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Violations</p>
              </div>
              <div class="icon">
                <i class="fas fa-tachometer-alt"></i>
              </div>
              <a href="#" class="small-box-footer">
               percentage of exceeded speed 
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>44</h3>

                <p>Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-graduate"></i>
              </div>
              <a href="#" class="small-box-footer">
                Number of registered students
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>65</h3>

                <p>Supervisors</p>
              </div>
              <div class="icon">
                <i class="fas fa-female"></i>
              </div>
              <a href="#" class="small-box-footer">
               Numebr of supervisors
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="ActivityGraphWrapper col-2">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Activity data</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-8">
          <line-chart></line-chart>
        </div>
        <div class="col-md-4">
          <p>Data points</p>
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

  import LineChart from './activity'

    export default{

       mounted(){
        this.renderChart({
          labels: ['January', 'February'],
          datasets: [
            {
              label: 'Data One',
              backgroundColor: '#f87979',
              data: [40, 20]
            }
          ]
        }, 
        {
          responsive: true,
          maintainAspectRatio: false
        })
       }
    })
</script>
