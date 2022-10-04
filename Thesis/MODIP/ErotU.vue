<template>
    <div>
        
        <CRow v-for="(entry, id) in erotR"
          :item="entry"
          :key="id">
      <CCol md="12">
          
        <div v-if="entry.tmima == utype">
        <CCard >
          <CCardHeader >
            <h1>{{entry.title}}</h1> 
            <p>Λήγει: {{entry.date}}</p>

            <CButton v-model="but" size="sm" color="primary" class="right" 
            @click="collapse1 = !collapse1" 
              v-on:click="apant(entry.erotid)" >
            <CIcon name="cil-cursor"/> Απάντηση</CButton>
              
            
            <div v-for="x in entry.users" :key="x"> 
              
              <div disabled v-if="x.user === uid ">
                <h5><CIcon name="cil-check-circle"/>{{' Απαντηθηκε'}}</h5>
              <CButton v-model="but" size="sm" color="primary" disabled class="right" >
            <CIcon name="cil-ban"/> Απάντηση</CButton>
              </div>
              </div>
              
            
          </CCardHeader>
          <CCollapse :show="collapse1" :duration="400" v-if="entry.erotid === bid || entry.erotid === null">
          <form @submit.prevent="AddA">
          <CCardBody >
            <CForm v-for="ent in entry.questions" :key="ent">
              <h3 >
                  {{ent.question}}
              </h3>
              <div v-for="e in ent.answers" :key="e">
                 
                <div v-if="e.type === 2">
                <input type="radio" v-model="ans[ent.quesid]" name="e.answer"  :value="e.ansid">{{e.answer}}  
                </div>
                <div v-if="e.type === 1">
                  <CTextarea
                placeholder="Περιεχόμενο Απάντησης..."
                v-model="texta"
                horizontal
                rows="3"
              />
              
                </div>
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

    </div>
</template>

<script>
import axios from 'axios'

export default {
    name:"ErotU",

    props:['erotR'],
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
            
        }
    },

    methods:{
        apant(id){
            this.bid=id
            this.apantisi=true
            },
            AddA(){
                if(confirm("Μετά την αποστολή δεν θα μπορείτε να ξανα απαντήσε σε αυτό το ερωτηματολόγιο. Είστε σίγουρος;")){
                var j=0;
                for(var i=0; i<this.ans.length; i++){
                    if(this.ans[i]!=null){
                        this.ans1[j]=this.ans[i];
                        j++;
                    }
                }
                
                axios.post('http://83.212.17.131/nikos/restApi/api/erot/apantisi.php',{uid:this.uid, apant: this.ans1})
                .then(res=>this.users=[...this.users,res.data])
                }
            }
        },

        created(){
     axios.post('http://localhost/login/validate.php',{ jwt: this.token})
       .then(resp=>{
          this.utype=resp.data.user.utype
          this.uid=resp.data.user.userid})
        .catch(err => console.log(err));
  
       
  }
    }
    

</script>

<style scoped>

 .right{
   position: absolute;
   right: 30px;
    top: 17px;
 }



</style>