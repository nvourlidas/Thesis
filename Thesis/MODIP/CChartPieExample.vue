<template>


  <CChartPie
    :datasets="defaultDatasets"
    :labels="ans"
    class="chart"
  />


</template>

<script>
import { CChartPie } from '@coreui/vue-chartjs'

export default {
  name: 'CChartPieExample',
  props:['erotI', 'erotM'],
  components: { CChartPie },

  data(){
    return {
      ans:[],
      ap:[]
    }
  },
  computed: {
    defaultDatasets () {
     
      return [
        {
          backgroundColor: [
            '#41B883',
            '#E46651',
            '#00D8FF',
            '#DD1B16',
            '#1b1ee5',
            '#e90e82',
            '#7b0ee9',
            '#ceec0d',
            '#898789',
            '#000000',
          ],
          data: this.ap
        }
      ]
    },
  },

  created(){
    
for(var i=0; i<this.erotM.length; i++){
      this.ans[i]=this.erotM[i].answer;
      this.ap[i]=this.erotM[i].apant;
    }

  }
}
</script>

<style scoped>
.chart{
  width:50%;
}
</style>