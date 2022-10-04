<template>
    <div>
        
        <CRow v-for="(entry, id) in pageOfItems"
          :item="entry"
          :key="id">
      <CCol md="12" v-if="entry.tmima == utype || entry.tmima==11">
          
        <div v-if="entry.apost == 2 && entry.energ == '1'">
          <CAlert :show="show2" :duration="5" closeButton color="success" 
          v-if="entry.erotid === bid || entry.erotid === null">Οι Απαντήσεις σας Αποθηκεύτηκαν</CAlert>
        <CCard >
          
          <CCardHeader >
              
            <h1>{{entry.title}}</h1> 
            <p>Λήγει: {{entry.date}}</p>
            <p >Τμήματος: {{entry.tmima1}}</p>
            <p >Υπηρεσίας: {{entry.idrima1}}</p>
            

            <CButton v-model="but" size="sm" color="primary" class="right" 
            @click="collapse1 = !collapse1" 
              v-on:click="apant(entry.erotid)" >
            <CIcon name="cil-cursor"/> Απάντηση</CButton>
              
            
            <div v-for="x in entry.users" :key="x"> 
              
              <div  v-if="x.user == uid ">
                <h5><CIcon name="cil-check-circle"/>{{' Απαντήθηκε'}}</h5>
              <CButton v-model="but" size="sm" color="primary" disabled class="right" >
            <CIcon name="cil-ban"/> Απάντηση</CButton>
              </div>
              </div>
              
          </CCardHeader>
          <CCollapse :show="collapse1" :duration="400" v-if="entry.erotid === bid || entry.erotid === null">
          <form @submit.prevent="AddA(entry.erotid)">
          <CCardBody >
            <CForm v-for="ent in entry.questions" :key="ent">
              <div v-if="ent.type === 2">
              <h3 >
                  {{ent.question}}
              </h3>
              <div v-for="e in ent.answers" :key="e">
                 
                
                <input type="radio" v-model="ans[ent.quesid]" name="e.answer"  :value="e.ansid">{{e.answer}}  
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
              />
              
                </div>
              
              <hr>
            </CForm>
            <CButton type="submit" size="sm" color="primary" ><CIcon name="cil-check-circle" /> Αποστολή Απαντήσεων</CButton>
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
    name:"Apantmodip",

    
    data(){
        return{
            apantisi:false,
            bid:'',
            collapse: false,
            collapse1: false,
            show2:false,
            utype:localStorage.getItem('tmh_2'),
            
            texta:'',
            ans:[],
            ans1:[],
            uid:localStorage.getItem('k_id'),
            users:[],
            erotim:[],
            pageOfItems: [],
        }
    },


    methods:{
        apant(id){
            this.bid=id
            this.apantisi=true
            },
            AddA(id){
                if(confirm("Μετά την αποστολή δεν θα μπορείτε να ξανα απαντήσε σε αυτό το ερωτηματολόγιο. Είστε σίγουρος;")){
                var j=0;
                for(var i=0; i<this.ans.length; i++){
                    if(this.ans[i]!=null){
                        this.ans1[j]=this.ans[i];
                        j++;
                    }
                }
                
                axios.post('http://83.212.17.131/nikos/restApi/api/erot/apantisi.php',{uid:this.uid, apant: this.ans1, text:this.texta})
                .then(res=>{for(var i=0; i<this.erotim.length; i++){
                          if(this.erotim[i].erotid == id){
                            this.erotim[i].users=[...this.erotim[i].users,res.data]
                          }
                        }
                        this.collapse1=false;
                        this.show2=true;
                    })
                }
            },
            onChangePage(pageOfItems) {
            this.pageOfItems = pageOfItems;
        }
        },

        created() {
     axios.get('http://83.212.17.165/nikos/restApi/api/erot/read.php')
     .then(res => {this.erotim = res.data
     
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