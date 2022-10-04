<template>
    <div>
        
        <CRow v-for="(entry, id) in pageOfItems"
          :item="entry"
          :key="id">
      <CCol md="12" v-if="entry.tmima == ttype || entry.tmima==11">
          
        <div v-if="entry.apost == '2' && entry.energ == '1'">
        <CCard >
          <CCardHeader >
            <h1>{{entry.title}}</h1> 
            <p>Λήγει: {{entry.date}}</p>
            <p >Τμήματος: {{entry.tmima1}}</p>
            <p >Υπηρεσίας: {{entry.idrima1}}</p>
          {{cdate}}
            <CButton v-model="but" size="sm" color="primary" class="right" 
            @click="collapse1 = !collapse1" 
              v-on:click="apant(entry.erotid)" >
            <CIcon name="cil-file"/> Λεπτομέριες</CButton>
              
            
             
              
              
              
              
              
              
            
          </CCardHeader>
          <CCollapse :show="collapse1" :duration="400" v-if="entry.erotid === bid || entry.erotid === null">
          <form @submit.prevent="AddA">
          <CCardBody >
            <CCardBody >
            <CForm v-for="ent in entry.questions" :key="ent">
              <div v-if="ent.type === 2">
              <h3 >
                  {{ent.question}}
              </h3>
              <div v-for="e in ent.answers" :key="e">
                 
                
                <input type="radio" disabled v-model="ans[ent.quesid]" name="e.answer"  :value="e.ansid">{{e.answer}}  
                </div>
                </div>
                <div v-if="ent.type == 1">
                  <h3>
                  {{ent.question}}
              </h3>
                  <CTextarea
                placeholder="Περιεχόμενο Απάντησης..."
                v-model="texta"
                horizontal
                rows="3"
                disabled
              />
              
                </div>
              <hr>
            </CForm>
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

export default {
    name:"energa",

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
            
            onChangePage(pageOfItems) {
            this.pageOfItems = pageOfItems;
        }
        },

        created() {
     axios.get('http://83.212.17.131/nikos/restApi/api/erot/read.php')
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



</style>