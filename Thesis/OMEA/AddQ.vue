<template>
    <div>
        <form @submit.prevent="addQe">
                          <CCardBody>
                            <CAlert :show="show" :duration="5" closeButton color="danger" >Παρακαλώ Συμπληρώστε όλα τα πεδία </CAlert>
                           <CCardHeader >
                             <h3> Εισαγωγή Νέας Ερώτησης</h3>
                          </CCardHeader>
                            <CInput
                          label="Ερώτηση:"
                          v-model="Nquestion"
                          name="question"
                          size="lg"
                          horizontal
                          placeholder="Εισαγωγή Ερώτησης..."
                        />
                        
                        <CSelect
                            label="Τύπος Απάντησης"
                            size="lg"
                            v-bind="id"
                            horizontal
                            :value.sync="selectedOption"
                            :options="selectOptions"
                            
                            placeholder="Παρακαλώ Επιλέξτε"
                          />

                          <div v-if="selectedOption === '1'">
                          
                          </div>
                          <div v-if="selectedOption === '2'">
                          <span class="scale">Επιλογή Αριθμού Απαντήσεων 
                            <input type="number" min="1" max="10" margin-left="100px" 
                            v-model="number" 
                            v-on:change="cNum(number)"
                            > 
                            </span>
                            
                            
                          <div v-for="(n, inde) in Sans" :key="inde" >
                            <CInput
                            label="Απάντηση :"
                            v-model="Sans[Sans.length -inde - 1]" 
                            name="Sans"
                            size="sm"
                            horizontal
                            placeholder="Προσθήκη Απάντησεις..."
                          />
                            </div>
                          </div>
              </CCardBody>
              <CCardFooter>
                <CButton type="submit" size="sm" color="primary" ><CIcon name="cil-check-circle"/> Εισαγωγή Ερώτησης</CButton>
              </CCardFooter>
                </form>
    </div>
</template>

<script>


export default {

    name: "AddQ",

    props:['passD'],

    data(){
        return {
            Nquestion:'',
            Sans:[],
            number: null,
            numbers: [],
            show:false,
            selectOptions: [
           { 
              value: '1', 
               label: 'Κείμενο'
             },
              { 
                value: '2', 
                label: 'Πολλαπλής Επιλογής'
              },
          ],
           selectedOption: '',
        }
    },

    methods:{

         addQe(){
           if(!this.Nquestion || !this.selectedOption){
          this.show=true;
          setTimeout(()=>this.show=false,2500);
        }else{
             this.$emit('add-q',this.Nquestion, this.passD, this.Sans, this.selectedOption)
        }
         },
        
        cNum(num) {
        this.numbers.length = num;
        this.Sans.length = num;
      },
    }

}
</script>

<style scoped>
 .scale {
   font-size: 20px;
    margin-left: 30%;
    margin-right: auto;
 }
</style>