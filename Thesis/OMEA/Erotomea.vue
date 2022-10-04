<template>
<div>
      <CRow v-for="(entry, id) in pageOfItems"
          :item="entry"
          :key="id"
          >
      <CCol md="12" v-if="entry.tmima == utype || entry.tmima == 11">
          
        <CCard v-if="uid == entry.crby || entry.crby == null">
          <CCardHeader >
            <h1>{{entry.title}}</h1> 
            <p>Λήγει: {{entry.date}}</p>
            <p >Τμήματος: {{entry.tmima1}}</p>
            <p >Υπηρεσίας: {{entry.idrima1}}</p>
            
          <div class="right">
                <b-modal  hide-backdrop content-class="shadow" id="modal-tall" title="Επεξεργασία Ερωτηματολογίου" v-if="entry.erotid === bid || entry.erotid === null">
                <br>
                <editEr :edit-t="entry.title" :edit-d="entry.erotid" :edit-q="entry.questions" v-on:edit-erot="change"/>
                </b-modal>
          </div>

          <CButton type="reset" size="sm" color="danger" class="but1"  @click="deleteE(entry.erotid)"><CIcon name="cil-ban"/> Διαγραφή</CButton>
          </CCardHeader>
          
          <CCardFooter v-if="entry.apost == '1'">
            <b-button class="button" v-b-modal.modal-tall v-on:click="fbid(entry.erotid)"><CIcon name="cil-pencil"/> Επεξεργασία</b-button> 
            
            <CButton type="reset" size="sm" color="success" class="but" @click="Apost(entry.erotid)"><CIcon name="cil-check-circle"/> Ενεργοποίηση</CButton>
            </CCardFooter>
        </CCard>
       
      </CCol>
      
    </CRow>
    <jw-pagination :items="erotim" @changePage="onChangePage" pageSize="3"></jw-pagination>
    <br>
   <br>
  <CAlert :show="show2" :duration="5" closeButton color="success" >Το Ερωτηματολόγιό σας Αποθηκεύτηκαν</CAlert>
    <CButton @click="collapse = !collapse" color="primary" class="mb-2">
            Προσθήκη Νέου
      </CButton>
    <CCollapse :show="collapse" :duration="400">
    <AddErot v-on:add-erot="addErot"/>
    </CCollapse>
  
  
  
  </div>
</template>



<script>

import AddErot from './AddErot';
import editEr from './editEr.vue';

import axios from 'axios';





export default {

    name: 'Erot',

    components: {
      
      AddErot,
      editEr,
     
      
    },

    data() {
        return {
            erotim:[],
            rad: [],
            popupActivo:false,
            collapse: false,
            collapse1: false,
            show2:false,
            bid: null,
            utype:'',
            apost: 2,
            utype:localStorage.getItem('tmh_2'),
            uid:localStorage.getItem('k_id'),
            
            pageOfItems: [],
            
            
        }
    },
    
   

    methods: {


      deleteE(erotid) {
        if(confirm("Είστε σίγουρος ότι θέλετε να γίνει Διαγραφή")){
      axios.delete(`http://83.212.17.131/nikos/restApi/api/erot/delete.php/?erotid=${erotid}`)
        .then( res=>{
          for(var i=0; i<this.erotim.length; i++){
            if(erotid==this.erotim[i].erotid){
              this.erotim.splice(i,1)
            }
          }
        })
      .catch(err => console.log(err));
        }
      },

      

      addErot(newErot,question, sans, type, date, idrima) {
      axios.post('http://83.212.17.131/nikos/restApi/api/erot/create.php', { title: newErot , question: question, answers: sans, type: type, date:date, tmima: this.utype, idrima:idrima, crby:this.uid})
      .then(res=>this.erotim=[...this.erotim,res.data], this.collapse=false, this.show2=true, setTimeout(()=>this.show2=false,2500))
      .catch(err => console.log(err));
      
     
    },

      Apost(erotid){
        if(confirm("Είστε σίγουρος ότι θέτε να γίνει Ενεργοποίηση;")){
          
      axios.post(`http://83.212.17.131/nikos/restApi/api/erot/apost.php`, {apost: this.apost, erotid: erotid})
        .then( res=>{
          for(var i=0; i<this.erotim.length; i++){
            if(erotid==this.erotim[i].erotid){
              this.erotim[i].apost=2;
            }
          }
        })
      .catch(err => console.log(err.response.data));
        }
      },

        fbid(id){
          this.bid=id
        
        },


      change(title, id){
       for(var i=0; i<this.erotim.length; i++){
         if(id==this.erotim[i].erotid){
            this.erotim[i].title=title;
          }
        }
      },

      
      onChangePage(pageOfItems) {
            this.pageOfItems = pageOfItems;
        }
    },

     created() {
     axios.get('http://83.212.17.131/nikos/restApi/api/erot/read.php')
     .then(res => {this.erotim = res.data

     })
     .catch(err => console.log(err));
    },

     
   
  }


  


</script>



<style scoped>
 .but{
   position: absolute;
  right: 20px; 
  
  

 }

 .but2{
   position: absolute;
left: 110px;

 }
 .button{
   background-color: #0000ff;
   color: white;
 }

 .right{
   position: absolute;
    right: 120px;
    top: 10px;
 }
.but1{
   position: absolute;
  right: 20px; 
  top:130px
 }


</style>


