<template>
    <div >
   <CForm @submit.prevent="changeT(editD, ctitle)">
                  <h4>{{editT}}</h4>
                    
                            <CInput 
                              v-model="ctitle"
                              name="ctitle"
                              size="lg"
                              horizontal
                              placeholder="Αλλαγή τίτλου σε..."
                            />
                            <CButton type="submit" size="sm" color="primary"  ><CIcon name="cil-pencil"/> Αλλαγή </CButton>
                </CForm>
                <br>
              
                <div v-for="(ent, index) in editQ" :key="index"  >
                        <CRow >
                      <CCol md="12">
                        <CCard >
                            <CJumbotron>
                          <CCardBody>
                            <CForm @submit.prevent="changeQ(ent.quesid, ent.questions)">
                              
                              <h2 >{{ent.question}}</h2>
                              
                              
                              <CInput 
                              v-model="ent.questions"
                              name="cquestion"
                              size="lg"
                              horizontal
                              placeholder="Αλλαγή Ερώτησης σε..."
                            />
                            
                            <CButton type="submit" size="sm" color="primary"  ><CIcon name="cil-pencil"/> Αλλαγή </CButton>
                            <CButton type="reset" size="sm" color="danger" class="but2" @click="deleteQ(ent.quesid)"><CIcon name="cil-ban"/> Διαγραφή</CButton>
                              <hr>
                            </CForm>
                        <div v-for="e in ent.answers" :key="e">
                          <div v-if="ent.type == 2" >
                          <CForm  @submit.prevent="changeA(e.ansid, e.answers)">
                            <h5>{{e.answer}}</h5>


                            <CInput 
                              v-model="e.answers"
                              name="canswer"
                              size="lg"
                              horizontal
                              placeholder="Αλλαγή απάντησης σε..."
                            />

                            <CButton type="submit" size="sm" color="primary"  ><CIcon name="cil-pencil"/> Αλλαγή </CButton>
                            <CButton type="reset" size="sm" color="danger" class="but2" @click="deleteA(e.ansid,ent.quesid)"><CIcon name="cil-ban"/> Διαγραφή</CButton>
                          </CForm>

                          <br>
                          </div>
                        </div>
                          <div v-if="ent.type == 2" >
                          <h3> Εισαγωγή Νέας Απάντησης</h3>
                          <CForm @submit.prevent="addA(ent.quesid)">
                            <CInput
                              label="Απάντηση"
                              v-model="Nanswer"
                              name="answer"
                              size="lg"
                              horizontal
                              placeholder="Προσθήκη Απάντησης..."
                            />

                             <CButton type="submit" size="sm" color="primary" ><CIcon name="cil-check-circle"/> Προσθήκη Απάντησης</CButton>
                          </CForm>
                          </div>
                        
                        </CCardBody>
                        </CJumbotron>
                        </CCard>
                      </CCol>
                    </CRow>
                    </div>
                    <div>
                        <AddQ :pass-d="editD" v-on:add-q="addQes"/>
                        </div>
    </div>
</template>


<script>
import axios from 'axios';
import AddQ from './AddQ.vue'

export default {
    name: "editE",

    components:{
        AddQ
    },

    props: ['editT', 'editD','editQ'],

    data(){
        return{
            ctitle:'',
            id:1,
            Nanswer:'',
        }
    },

    methods:{
            changeT(id, title) {
        axios.post('http://83.212.17.131/nikos/restApi/api/erot/update.php', { title: title , erotid: id})
        .then(this.editT=title,this.$emit('edit-erot', title, id))
        },

        changeQ(quesid, cques){
      axios.post('http://83.212.17.131/nikos/restApi/api/erot/qupdate.php', { question: cques , quesid: quesid})
      .then(res=>{for(var i=0; i<this.editQ.length; i++){
         if(quesid==this.editQ[i].quesid){
            this.editQ[i].question=cques;
          }
        }})
      .catch(err => console.log(err));
    },

    deleteQ(quesid) {
      if(confirm("Είστε σίγουρος ότι θέλετε να γίνει Διαγραφή")){
      axios.delete(`http://83.212.17.131/nikos/restApi/api/erot/qdelete.php/?quesid=${quesid}`)
        .then(res=>{
          for(var i=0; i<this.editQ.length; i++){
            if(quesid==this.editQ[i].quesid){
              this.editQ.splice(i,1)
            }
          }
        })
      .catch(err => console.log(err));
      }
      },

      changeA(ansid, cans){
      axios.post('http://83.212.17.131/nikos/restApi/api/erot/aupdate.php', { answer: cans , ansid: ansid})
      .then(res=>{for(var i=0; i<this.editQ.length; i++){
          for(var j=0; j<this.editQ[i].answers.length; j++){
         if(ansid==this.editQ[i].answers[j].ansid){
            this.editQ[i].answers[j].answer=cans;
          }
          }
        }})
      .catch(err => console.log(err));
      
    },

    deleteA(ansid,quesid) {
      if(confirm("Είστε σίγουρος ότι θέλετε να γίνει Διαγραφή")){
      axios.delete(`http://83.212.17.131/nikos/restApi/api/erot/adelete.php/?ansid=${ansid}`)
        .then(res=>{for(var i=0; i<this.editQ.length; i++){
          for(var j=0; j<this.editQ[i].answers.length; j++){
            if(ansid==this.editQ[i].answers[j].ansid){
            this.editQ[i].answers.splice(j,1)
                }
            }
        }
        })
      .catch(err => console.log(err));
      }
      },

      addA(quesid){
      axios.post('http://83.212.17.131/nikos/restApi/api/erot/acreate.php', { answer: this.Nanswer , question_id: quesid})
      .then(res=>{for(var i=0; i<this.editQ.length; i++){
          if(quesid==this.editQ[i].quesid){
              this.editQ[i].answers=[...this.editQ[i].answers,res.data]
          }
      }
      })
      .catch(err => console.log(err));
      
    },

    addQes(ques,id,ans,stype){
        const req={
            question: ques ,
             erot_id: id,
              answers:ans, 
              type:stype
        }
      axios.post('http://83.212.17.131/nikos/restApi/api/erot/qcreate.php', req)
      .then(res=>this.editQ=[...this.editQ,res.data])
      .catch(err => console.log(err));
      
    },
  }   
}
</script>