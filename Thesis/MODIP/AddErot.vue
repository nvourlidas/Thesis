<template>
    <div>
  <CCard>
          <form @submit.prevent="addE">
          <CCardBody>
           <CAlert :show="show" :duration="5" closeButton color="danger" >Παρακαλώ Συμπληρώστε όλα τα πεδία </CAlert>
            <CInput
              label="Τίτλος"
              v-model="title"
              name="name"
              size="lg"
              horizontal
              placeholder="Προσθήκη Τίτλου..."
            />

            <CJumbotron>
              <CSelect
                label="Επιλογή Τμήματος"
                size="lg"
                v-bind="id"
                horizontal
                :value.sync="selectedOption1"
                :options="selectOptions1"
                
                placeholder="Παρακαλώ Επιλέξτε"
              />

              <CSelect
                label="Επιλογή Υπηρεσίας"
                size="lg"
                v-bind="id"
                horizontal
                :value.sync="selectedOption2"
                :options="selectOptions2"
                
                placeholder="Παρακαλώ Επιλέξτε"
              />
            <CInput
              label="Ερώτηση:"
              v-model="question"
              name="question"
              size="lg"
              horizontal
              placeholder="Προσθήκη Ερώτησης..."
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
                 
               <div v-for="(n, index) in Sans" :key="index" >
               <CInput
              label="Απάντηση :"
              v-model="Sans[Sans.length -index - 1]" 
              name="Sans"
              size="sm"
              horizontal
              placeholder="Προσθήκη Απάντησης..."
            />
              </div>
              
              </div>
              
              <CInput label="Επιλογή Ημερομηνίας Λήξης:" 
              type="date"
               v-model="date" 
               size="lg"
               />
               {{date}}
            </CJumbotron>
          </CCardBody>
          <CCardFooter>
            <CButton  type="submit" size="sm" color="primary" ><CIcon name="cil-check-circle"/> Εισαγωγή</CButton>
          </CCardFooter>
          </form>
        </CCard>

      



    </div>
</template>

<script>


export default {
    
    name: "AddErot",

      data() {
        return {
         
          title: '',
          question: '',
          ans1: '',
          ans2: '',
          number: null,
          numbers: [],
          Sans:[],
          date:'',
          show: false,
   
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

           selectOptions1: [
           { 
              value: '4', 
               label: 'Ηλεκτρολόγων Μηχανικών και Μηχανικών Υπολογιστών'
             },
              { 
                value: '5', 
                label: 'Μηχανολόγων Μηχανικών'
              },
              { 
              value: '6', 
               label: 'Χημικών Μηχανικών'
             },
              { 
                value: '9', 
                label: 'Παιδαγωγικό Νηπιαγωγών'
              },
              { 
                value: '10', 
                label: 'Εικαστικών και Εφαρμοσμένων Τεχνών'
              },
              { 
                value: '11', 
                label: 'Όλα τα Τμήματα'
              },
          ],
           selectedOption1: '',

           selectOptions2: [
           { 
              value: '1', 
               label: 'Γραμματεία Πρύτανη'
             },
              { 
                value: '2', 
                label: 'Γραμματεία Συγκλήτου'
              },
              { 
              value: '3', 
               label: 'Γραμματεία Ειδικού Λογαριασμού Κονδυλίων Έρευνας'
             },
              { 
                value: '4', 
                label: 'Γραφείο Διασύνδεσης'
              },
              { 
                value: '5', 
                label: 'Γραφείο Πρακτικής Άσκησης'
              },
              { 
                value: '6', 
                label: 'Διεύθυνση Διοίκησης και Οικονομικής Διαχείρισης'
              },
              { 
              value: '7', 
               label: 'Δομή Απασχόλησης και Σταδιοδρομίας'
             },
              { 
                value: '8', 
                label: 'Μονάδα Διασφάλισης Ποιότητας'
              },
              { 
              value: '9', 
               label: 'Τμήμα Ακαδημαϊκών Θεμάτων'
             },
              { 
                value: '10', 
                label: 'Τμήμα Διεθνών Σχέσεων και Ευρωπαϊκών Προγραμμάτων'
              },
              { 
                value: '11', 
                label: 'Τμήμα Διοίκησης Προσωπικού'
              },
              { 
                value: '12', 
                label: 'Τμήμα Μηχανοργάνωσης'
              },
              { 
                value: '13', 
                label: 'Τμήμα Οικονομικής Διαχείρισης'
              },
              { 
                value: '14', 
                label: 'Τμήμα Τεχνικών Υπηρεσιών'
              },
          ],
           selectedOption2: '',
        }
  },

  methods: {
    addE() {
      if(!this.title || !this.question || !this.selectedOption || !this.selectedOption1 || !this.selectedOption2 || !this.date){
          this.show=true;
          setTimeout(()=>this.show=false,2500);
        }else{
        this.$emit('add-erot', this.title, this.question, this.Sans, this.selectedOption, this.date, this.selectedOption1, this.selectedOption2);
        }
    },
        cNum(num) {
      this.numbers.length = num;
      this.Sans.length = num;
    },

    
    

    
  },
  
}
</script>


<style scoped>
 .scale {
   font-size: 20px;
    margin-left: 30%;
    margin-right: auto;
 }
</style>