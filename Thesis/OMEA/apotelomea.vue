<template>
    <div>
        
        <CRow v-for="(entry, id) in pageOfItems"
          :item="entry"
          :key="id">
      <CCol md="12" v-if="entry.tmima == ttype || entry.tmima == 11">
          
        <div v-if="entry.apost == '2' && entry.apant2 !==0" >
        <CCard >
          <CCardHeader >
            <h1>{{entry.title}}</h1> 
            <p>Λήγει: {{entry.date}}</p>
            <p >Τμήματος: {{entry.tmima1}}</p>
            <p >Υπηρεσίας: {{entry.idrima1}}</p>
            <p >Απαντήθηκε από: {{entry.apant2}} Καθηγητές</p>

            <CButton v-model="but" size="sm" color="primary" class="right" 
            @click="collapse1 = !collapse1" 
              v-on:click="apant(entry.erotid)" >
            <CIcon name="cil-chart-pie"/> Λεπτομέριες</CButton>
              
            
             
              
              
              
              
              
              
            
          </CCardHeader>
          <CCollapse :show="collapse1" :duration="400" v-if="entry.erotid === bid || entry.erotid === null">
          <form @submit.prevent="AddA">
          <CCardBody >
            <CCardBody >
            <CForm v-for="ent in entry.questions" :key="ent">
              <div v-if="ent.type == 2">
              <h3 >
                  {{ent.question}}
              </h3>

              <p>
                Όλες οι τιμές έιναι (%)
              </p>
            
                
              <CChartPieExample :erot-i="ent.quesid" :erot-m="ent.answers" />
              <CChartBarExample :erot-i="ent.question" :erot-m="ent.answers" class="bar"  />
              
              </div>
              <br>
              
            </CForm>
            <div class="right">
                <b-modal  hide-backdrop content-class="shadow" id="modal-tall" title="Απαντήσεις Κειμένου" v-if="entry.erotid === bid || entry.erotid === null">
                <div v-for="entr in entry.questions" :key="entr">
                 <div v-if="entr.type == 1">
                   
                   <div v-for="x in entr.answers" :key="x">
                     <CJumbotron v-for="y in x.texta" :key="y">
                   <p>{{y.text}}</p>
                     </CJumbotron>
                   </div>
                 </div>
                </div>
                </b-modal>
          </div>
          <b-button class="button" v-b-modal.modal-tall v-on:click="fbid(entry.erotid)"><CIcon name="cil-pencil"/> Απαντήσεις Κειμένου</b-button>
          <hr>
          </CCardBody>
            
          </CCardBody>
          </form>
          </CCollapse>
        </CCard>
        </div>
      </CCol>
        </CRow>
<jw-pagination :items="erotim" @changePage="onChangePage" pageSize="3"></jw-pagination>
    </div>
</template>

<script>
import axios from 'axios'
import CChartPieExample from './CChartPieExample';
import CChartBarExample from './CChartBarExample';

export default {
    name:"energa",
    components: {
      CChartPieExample,
      CChartBarExample,
    },
    

    data(){
        return{
            apantisi:false,
            bid:'',
            collapse: false,
            collapse1: false,
            utype:'',
            token:localStorage.getItem('token'),
            texta:'',
            ans:[],
            ans1:[],
            uid:'',
            users:[],
            erotim:[],
            ttype:localStorage.getItem('tmh_2'),
            pageOfItems: [],
        }
    },

    methods:{
        apant(id){
            this.bid=id
            this.apantisi=true
            },
            fbid(id){
          this.bid=id
        
        },
        onChangePage(pageOfItems) {
            this.pageOfItems = pageOfItems;
        }
            
        },

        created() {
     axios.get('http://83.212.17.131/nikos/restApi/api/erot/readA.php')
     .then(res => {this.erotim = res.data,
     this.utype=localStorage.getItem('user_type')
     })
     .catch(err => console.log(err));
    },
    }
    

</script>

<style scoped>

 .right{
   position: absolute;
   right: 30px;
    top: 17px;
 }
.bar{
   width: 50%;
}


</style>