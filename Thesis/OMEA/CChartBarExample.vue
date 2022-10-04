<template>
  <CChartBar
    :datasets="defaultDatasets"
    :labels="ans"
  />
</template>

<script>
import { CChartBar } from '@coreui/vue-chartjs'

export default {
  name: 'CChartBarExample',
  components: { CChartBar },
  props:['erotI', 'erotM'],

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
          label: "Καθηγητές που απάντησαν",
          backgroundColor: '#f87979',
          data: this.ap
        }
      ]
    }
  },

created(){  
for(var i=0; i<this.erotM.length; i++){
      this.ans[i]=this.erotM[i].answer;
      this.ap[i]=this.erotM[i].kath;
    }
  }
}
</script>
